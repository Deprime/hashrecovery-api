<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\{
  Request,
  JsonResponse,
};
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
  /**
   * List
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function list(Request $request): JsonResponse
  {
    $page_list = Page::query()
      ->with('language')
      ->get();

    return response()->json($page_list);
  }

  /**
   * Get
   * @param  int $page_id
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function get(Request $request,int $page_id): JsonResponse
  {
    $user = $request->user();

    $post = Page::query()
      ->with('language')
      ->where('id', $page_id)
      ->first();

    if ($post) {
      return response()->json($post);
    }
    return response()->json([], Response::HTTP_NOT_FOUND);
  }
}
