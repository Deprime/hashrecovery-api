<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;


use App\Services\{
  RigService,
};

class RigController extends Controller
{
  /**
   * Connection
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function connection(Request $request)
  {
    $response = RigService::connection();
    return response()->json($response, Response::HTTP_OK);
  }

  /**
   * Access
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function access(Request $request)
  {
    $response = RigService::access();
    return response()->json($response, Response::HTTP_OK);
  }

  /**
   * Get
   * @return \Illuminate\Http\JsonResponse
   */
  private function get(Request $request, int $agent_id, $json_response = true)
  {
    $response = RigService::getAgent($agent_id);
    return $json_response ? response()->json($response, Response::HTTP_OK) : $response;
  }

  /**
   * list Agents
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function listAgents(Request $request)
  {
    $lifetime = 60; // Seconds
    if (Cache::has('agents')) {
      $data = Cache::get('agents');
    }
    else {
      $data = Cache::remember('users', $lifetime, function () use ($request) {
        $response = RigService::listAgent();
        $agents   = $response->agents;

        foreach ($agents as $key => $agent) {
          $agents[$key]->state = RigService::getAgent($agent->agentId);
        }
        return $agents;
      });
    }
    return response()->json(['agents' => $data], Response::HTTP_OK);
  }
}
