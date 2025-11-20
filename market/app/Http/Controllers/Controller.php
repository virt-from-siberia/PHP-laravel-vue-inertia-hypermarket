<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="Hypermarket API",
 *     version="1.0.0",
 *     description="API документация для гипермаркета",
 *     @OA\Contact(
 *         email="admin@hypermarket.com"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://127.0.0.1:8000",
 *     description="Local Development Server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
abstract class Controller
{
    //
}
