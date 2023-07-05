<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Services\{
  CurrencyService,
};

class SettingsSeeder extends Seeder
{
  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {
    $usd2rub = CurrencyService::getUsd2Rub();
    $table = 'settings';
    $contact = "ℹ Контакты. Измените их в настройках бота.
    ➖➖➖➖➖➖➖➖➖➖➖➖➖
    <b>♻ Bot created by @djimbox</b>
    <b>⚜ Bot Version:</b> <code>2.9</code>
    <b>🔗 Topic Link:</b> <a href='https://lolz.guru/threads/1888814/'><b>Click me</b></a>
    <b>🍩 Donate to the author:</b> <a href='https://yoomoney.ru/to/410012580032553'><b>Click me</b></a>";

    $faq = "Приветствую тебя, {firstname}!
    Зачем нужен сервис?
    - Сервис позволяет проводить анализ безопасности паролей.
    Что для этого нужно?
    - Вам необходимо загрузить хэш который предварительно выбрав тип хэширования.
    - Сколько это стоит?
    Загрузка хэша бесплатная в базовом режиме. Для просмотра восстановленного пароля оплата составляет 10$.";

    $data = [
      ['key' => 'contact',        'type' => 'string',  'value' => $contact],
      ['key' => 'faq',            'type' => 'string',  'value' => $faq],
      ['key' => 'status',         'type' => 'boolean', 'value' => true],
      ['key' => 'status_buy',     'type' => 'boolean', 'value' => true],
      ['key' => 'profit_buy',     'type' => 'boolean', 'value' => true],
      ['key' => 'profit_refill',  'type' => 'boolean', 'value' => true],
      ['key' => 'taskpriority',   'type' => 'integer', 'value' => 989998717],
      ['key' => 'cracker_id',     'type' => 'integer', 'value' => 8],
      // ['key' => 'rig_token',      'type' => 'string', 'value' => "xxx"],
      ['key' => 'usd2rub',        'type' => 'integer', 'value' => $usd2rub],
    ];
    \DB::table($table)->truncate();
    \DB::table($table)->insert($data);
  }
}
