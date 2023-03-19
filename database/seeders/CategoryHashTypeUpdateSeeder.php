<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoryHashTypeUpdateSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
      // WPA/WPA2 HASH (-m 22000, WPA*01*..., WPA*02*...)
      \DB::table('storage_category')
        ->where('category_id', 784573279)->update(['hash_type_id' => 22000]);

      // WPA/WPA2 EAPOL (cap/hccap/hccapx handshake)
      // \DB::table('storage_category')
      //   ->where('category_id', 272097516)->update(['hash_type_id' => ??]);

      // MD5
      \DB::table('storage_category')
        ->where('category_id', 442918875)->update(['hash_type_id' => 0]);

      // SHA1
      \DB::table('storage_category')
        ->where('category_id', 811361723)->update(['hash_type_id' => 100]);

      // MySQL 3.23
      \DB::table('storage_category')
        ->where('category_id', 385802095)->update(['hash_type_id' => 200]);

      // MySQL 4.1/5+
      \DB::table('storage_category')
        ->where('category_id', 732976086)->update(['hash_type_id' => 300]);

      // NTLM
      \DB::table('storage_category')
        ->where('category_id', 283718571)->update(['hash_type_id' => 1000]);

      // NetNTLMv1
      \DB::table('storage_category')
        ->where('category_id', 150899424)->update(['hash_type_id' => 5500]);

      // NetNTLMv2
      \DB::table('storage_category')
        ->where('category_id', 322441907)->update(['hash_type_id' => 5600]);

      // phpass, MD5(Wordpress, Joomla, phpBB3)
      \DB::table('storage_category')
        ->where('category_id', 496407700)->update(['hash_type_id' => 400]);

      // vBulletin < v3.8.5
      \DB::table('storage_category')
        ->where('category_id', 882221697)->update(['hash_type_id' => 2611]);

      // vBulletin ≥ v3.8.5
      \DB::table('storage_category')
        ->where('category_id', 945220710)->update(['hash_type_id' => 2711]);

      // BTC/LTC wallet (Bitcoin Core wallet.dat hash $bitcoin$96$/$64$)
      \DB::table('storage_category')
        ->where('category_id', 698323503)->update(['hash_type_id' => 11300]);

      // MetaMask Wallet
      \DB::table('storage_category')
        ->where('category_id', 107332098)->update(['hash_type_id' => 26600]);

      // 2100 - Domain Cached Credentials 2 (DCC2), MS Cache
      \DB::table('storage_category')
        ->where('category_id', 469794969)->update(['hash_type_id' => 2100]);

      // 1100 - Domain Cached Credentials (DCC), MS Cache
      \DB::table('storage_category')
        ->where('category_id', 464175727)->update(['hash_type_id' => 1100]);

      // Kerberos 5, etype 23, TGS-REP
      \DB::table('storage_category')
        ->where('category_id', 661186896)->update(['hash_type_id' => 13100]);

      // Kerberos 5, etype 23, AS-REP (-m 18200)
      \DB::table('storage_category')
        ->where('category_id', 311412923)->update(['hash_type_id' => 18200]);

      // Bitwarden
      \DB::table('storage_category')
        ->where('category_id', 283654497)->update(['hash_type_id' => 23400]);

      // Phantom Wallet
      // \DB::table('storage_category')
      //   ->where('category_id', 640437610)->update(['hash_type_id' => ??]);

      // bcrypt $2*$, Blowfish (Unix)
      \DB::table('storage_category')
        ->where('category_id', 705498582)->update(['hash_type_id' => 3200]);
    }
}
