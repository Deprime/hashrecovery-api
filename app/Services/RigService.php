<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class RigService {

  /**
   * Request
   */
  public static  function request($payload, $decode = true, $needToken = true) {
    $url = config('services.rig.url');
    $payload["accessKey"] = config('services.rig.token');

    $postdata = json_encode($payload);
    $ch = curl_init($url);
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
   */
  public static function connection() {
    $data = [
      "section" => "test",
      "request" => "connection",
    ];
    $response = self::request($data, true, false);
    return $response;
  }

  /**
   * Access
   */
  public static function access()
  {
    $data = [
      "section" => "test",
      "request" => "access",
    ];
    $response = self::request($data);
    return $response;
  }

  /**
   * Get agent
   */
  public static function getAgent(int $agent_id)
  {
    $data = [
      "section" => "agent",
      "request" => "get",
      "agentId" => $agent_id,
    ];
    $response = self::request($data);
    return $response;
  }

  /**
   * List agent
   */
  public static function listAgent()
  {
    $data = [
      "section" => "agent",
      "request" => "listAgents",
    ];
    $response = self::request($data);
    return $response;
  }

  /**
   * Create hash list
   * @param int $hashTypeId
   * @param string $encodedHash
   * @return object
   */
  public static function createHashlist(int $hashTypeId, string $encodedHash)
  {
    $data = [
      "section"       => "hashlist",
      "request"       => "createHashlist",
      "accessGroupId" => 1,
      "brainFeatures" => 0,
      "data"          => $encodedHash, // base64 encoded hash
      "format"        => 0,
      "hashtypeId"    => $hashTypeId,
      "separator"     =>":",
      "isHexSalt"     => false,
      "isSalted"      => false,
      "isSecret"      => true,
      "useBrain"      => false,
      "name"          => date('Y-m-d H:i:s'),
    ];
    $response = self::request($data);
    return $response;
  }

  /**
   * Run super task
   * @param int $hashlistId
   * @param int $supertaskId
   * @return object
   */
  public static function runSupertask(int $hashlistId, int $supertaskId)
  {
    $data = [
      "section"     => "task",
      "request"     => "runSupertask",
      "hashlistId"  => $hashlistId,
      "supertaskId" => $supertaskId,
      "crackerVersionId" => 2,
    ];
    $response = self::request($data);
    return $response;
  }

  /**
   * List tasks
   * @return object
   */
  public static function listTasks()
  {
    $data = [
      "section" => "task",
      "request" => "listTasks",
    ];
    $response = self::request($data);
    return $response;
  }


  /**
   * Set supertask priority
   * @param int $supertaskId
   * @param int $priority
   * @return object
   */
  public static function setSupertaskPriority(int $supertaskId, int $priority)
  {
    $data = [
      "section"           => "task",
      "request"           => "setSupertaskPriority",
      "supertaskId"       => $supertaskId,
      "supertaskPriority" => $priority,
    ];
    $response = self::request($data);
    return $response;
  }
}
