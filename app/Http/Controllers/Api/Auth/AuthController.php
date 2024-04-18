<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     ** path="/login",
     *  operationId="authLogin",
     *  tags={"Auth"},
     *  summary="User Login",
     *
     *  @OA\RequestBody(
     *      @OA\JsonContent(),
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              type="object",
     *              required={"email", "password"},
     *              @OA\Property(property="email"),
     *              @OA\Property(property="password")
     *          ),
     *      ),
     *  ),
     *
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *      )
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="Unauthenticated"
     *  ),
     *  @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Not Found"
     *  ),
     *  @OA\Response(
     *      response=403,
     *      description="Forbidden"
     *  )
     * )
     **/
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The credentials you entered are incorrect.']
            ]);
        }

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('laravel_api_token')->plainTextToken
        ]);
    }

    /**
     * @OA\Post(
     ** path="/logout",
     *  operationId="authLogout",
     *  tags={"Auth"},
     *  summary="User Logout",
     *  security={{"bearerAuth":{}}},
     *
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *      )
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="Unauthenticated"
     *  ),
     *  @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="Not Found"
     *  ),
     *  @OA\Response(
     *      response=403,
     *      description="Forbidden"
     *  ),
     * )
     **/
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }
}
