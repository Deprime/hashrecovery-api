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

use App\Models\{
  Rig,
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
    $cache_key = 'rig_agents';
    $lifetime = 60; // Seconds
    if (Cache::has($cache_key)) {
      $data = Cache::get($cache_key);
    }
    else {
      $data = Cache::remember($cache_key, $lifetime, function () use ($request) {
        $response = RigService::listAgent();
        $agents   = $response->agents;
        $rigs     = [];
        $faker    = \Faker\Factory::create();

        foreach ($agents as $key => $agent) {
          $agents[$key]->state = RigService::getAgent($agent->agentId);
          $rig = Rig::where('agent_id', $agent->agentId)->first();
          $rig = ($rig)
            ? $rig
            : Rig::create([
              'agent_id' => $agent->agentId,
              'real_name' => $agent->name,
              'name' => $faker->state(). " " . $faker->buildingNumber() . $agent->agentId,
            ]);
          $rig->last_activity = isset($agents[$key]->state->lastActivity->time)
            ? $agents[$key]->state->lastActivity->time
            : 0;
          $rigs[] = $rig;
        }

        return $rigs;
      });
    }
    return response()->json(['agents' => $data], Response::HTTP_OK);
  }
}
