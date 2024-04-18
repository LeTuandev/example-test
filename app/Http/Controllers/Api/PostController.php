<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Services\Api\PostService;
use App\Http\Resources\PostResource;
use App\Http\Requests\Api\Post\StoreRequest;
use App\Http\Requests\Api\Post\UpdateRequest;
use App\Models\Post;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    /**
     * @OA\Get(
     *     path="/posts",
     *     summary="Get a list of post",
     *     tags={"Posts"},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function index()
    {
        $data = $this->postService->getIndexData();
        if ($data['status'] !== 200) {
            return [];
        }
        return $data;
    }

    /**
     * @OA\Post(
     ** path="/posts",
     *  tags={"Posts"},
     *  summary="create new posts",
     *  security={{"bearerAuth":{}}},
     *
     *  @OA\RequestBody(
     *      @OA\JsonContent(),
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              type="object",
     *              required={"title", "description", "content", "slug"},
     *              @OA\Property(property="title", type="string"),
     *              @OA\Property(property="description", type="string"),
     *              @OA\Property(property="content", type="string"),
     *              @OA\Property(property="slug", type="string"),
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
     *  ),
     * )
     **/
    public function store(StoreRequest $request)
    {
        $data = $this->postService->createPost($request->all());
        if ($data['status'] !== 200) {
            return [];
        }
        return $data;
    }

    /**
     * @OA\Get(
     *     path="/posts/{post}",
     *     summary="Get detail of post",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *      name="post",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    public function show(Post $post)
    {
        return [
            'status' => '200',
            'message' => 'success',
            'data' => PostResource::make($post),
        ];
    }

    /**
     * @OA\Put(
     ** path="/posts/{post}",
     *  tags={"Posts"},
     *  summary="update post",
     *  security={{"bearerAuth":{}}},
     *
     *   @OA\Parameter(
     *      name="post",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *     )
     *   ),
     *  @OA\RequestBody(
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(property="title", type="string"),
     *          @OA\Property(property="description", type="string"),
     *          @OA\Property(property="content", type="string"),
     *          @OA\Property(property="slug", type="string"),
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
     *  ),
     * )
     **/
    public function update(UpdateRequest $request, Post $post)
    {
        return $this->postService->updatePost($request->all(), $post);
    }

    /**
     * @OA\Delete(
     ** path="/posts/{post}",
     *  tags={"Posts"},
     *  summary="update post",
     *  security={{"bearerAuth":{}}},
     *
     *   @OA\Parameter(
     *      name="post",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *     )
     *   ),
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
    public function destroy(Post $post)
    {
        return $this->postService->deletePost($post);
    }
}
