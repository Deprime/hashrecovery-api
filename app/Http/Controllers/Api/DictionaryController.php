<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use App\Models\{
  PostStatus,
  Category,
};

use App\ValueObjects\{
  PhonePrefix,
};

class DictionaryController extends Controller
{
  /**
   * Phone prefix list
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function phonePrefixList(Request $request)
  {
    $phone_prefixes = PhonePrefix::list();
    return response()->json($phone_prefixes, Response::HTTP_OK);
  }

  /**
   * Post status list
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function eventStatusList(Request $request): JsonResponse
  {
    $post_status_list = PostStatus::query()->get();
    return response()->json($post_status_list, Response::HTTP_OK);
  }

  /**
   * Category  list
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function categoryList(Request $request): JsonResponse
  {
    $category_list = Category::query()->orderBy('order')->get();
    return response()->json($category_list, Response::HTTP_OK);
  }
}
