<?php

namespace App\Models;

class Admin
{
    static function get($role_id = false)
    {
        if(!$role_id)
            $role_id = getenv('LAYANAN_API_ROLE_ID','');
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => getenv('LAYANAN_API_URL',''),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'user_key' => getenv('LAYANAN_USER_KEY',''),
                'pass_key' => getenv('LAYANAN_PASS_KEY',''), 
                'role_id'  => $role_id
            )
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // return $response;
        return json_decode($response);
    }
}
