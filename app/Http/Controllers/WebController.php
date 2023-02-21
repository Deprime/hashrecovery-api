<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\{
  User,
  Task,
  Message,
};

class WebController extends Controller
{
  public function index(Request $request)
  {
    return view('welcome');
  }
}
