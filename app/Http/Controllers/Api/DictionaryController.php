<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use App\Models\{
  Position,
  Category,
};


class DictionaryController extends Controller
{
  /**
   * Position list
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function positionList(Request $request)
  {
    $positions = Position::with(['category'])->get();
    return response()->json($positions, Response::HTTP_OK);
  }

  /**
   * Category list
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function categoryList(Request $request)
  {
    $categories = Category::with(['positions'])->orderByDesc('sortby')->get();
    return response()->json($categories, Response::HTTP_OK);
  }
}
