<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *  title="test",
 *  version="1.0.0",
 * ),
 * @OA\Server(
 *  url=L5_SWAGGER_CONST_HOST
 * ),
 * @OA\SecurityScheme(
 *  securityScheme="bearerAuth",
 *  in="header",
 *  name="bearerAuth",
 *  type="http",
 *  scheme="bearer",
 *  bearerFormat="JWT",
 * ),
 */
abstract class Controller
{
    //
}
