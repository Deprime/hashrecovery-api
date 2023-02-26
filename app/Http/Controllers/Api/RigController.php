<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;

class RigController extends Controller
{

  protected const URL   = "http://178.21.10.6:80/api/user.php";
  protected const TOKEN = "78ed7GfOs9knkBeXsf7DsRlLWsQrxX";

  /**
   * Send method
   */
  private function send($payload, $decode = true) {
    $postdata = json_encode($payload);
    $ch = curl_init(static::URL);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $result = curl_exec($ch);
    curl_close($ch);
    return $decode ? json_decode($result) : $result;
  }

  /**
   * Connection
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function connection(Request $request)
  {
    $data = [
      "section" => "test",
      "request" => "connection",
    ];
    $response = $this->send($data);
    return response()->json($response, Response::HTTP_OK);
  }

  /**
   * Access
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function access(Request $request)
  {
    $data = [
      "section"   => "test",
      "request"   => "access",
      "accessKey" => static::TOKEN,
    ];
    $response = $this->send($data);
    return response()->json($response, Response::HTTP_OK);
  }

  /**
   * Get
   * @return \Illuminate\Http\JsonResponse
   */
  private function get(Request $request, int $agent_id, $json_response = true)
  {
    $data = [
      "section"   => "agent",
      "request"   => "get",
      "agentId"   => $agent_id,
      "accessKey" => static::TOKEN,
    ];
    $response = $this->send($data);
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
        $payload = [
          "section"   => "agent",
          "request"   => "listAgents",
          "accessKey" => static::TOKEN,
        ];

        $response = $this->send($payload);
        $agents   = $response->agents;

        foreach ($agents as $key => $agent) {
          $agents[$key]->state = $this->get($request, $agent->agentId, false);
        }
        return $agents;
      });
    }
    return response()->json(['agents' => $data], Response::HTTP_OK);
  }
}
