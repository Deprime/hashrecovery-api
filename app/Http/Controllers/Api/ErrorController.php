<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ErrorController extends Controller
{
  /**
   * List
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function unauthorized(Request $request)
  {
    return response()->json([Response::HTTP_FORBIDDEN . ": HTTP_FORBIDDEN"], Response::HTTP_FORBIDDEN);
  }
}
