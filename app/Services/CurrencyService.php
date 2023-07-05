<?php

namespace App\Services;

use Illuminate\Support\Collection;
// use Illuminate\Support\Facades\Hash;

use App\Models\{
  Setting,
};

class CurrencyService {
  /**
   * Request
   */
  public static function request($decode = true) {
    $key     = "04102e9523437737843fb4a857c3bd67dc626508";
    $host    = "https://iss.moex.com/iss";
    $uri     = "/engines/currency/markets/selt/securities.jsonp";
    $params  = "&iss.meta=off&iss.only=securities%2Cmarketdata&securities=CETS%3AUSD000UTSTOM%2CCETS%3AEUR_RUB__TOM〈=ru";
    $api_url = "{$host}{$uri}?callback=iss_jsonp_{key}{$params}";

    $api_url = "https://iss.moex.com/iss/engines/currency/markets/selt/securities.jsonp?iss.only=securities%2Cmarketdata&securities=CETS%3AUSD000UTSTOM%2CCETS%3AEUR_RUB__TOM〈=ru";

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    return $decode ? json_decode($result) : $result;
  }

  /**
   * Get USD to RUB pair
   */
  public static function getUsd2Rub() {
    $response = self::request();
    $usd2rub  = $response->securities->data[0][15] ?? null;
    return $usd2rub;
  }
}
