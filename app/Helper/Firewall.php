<?php
/**
 * Created by PhpStorm.
 * User: xuxu
 * Date: 2018/2/23
 * Time: 下午3:31
 */

namespace App\Helper;

use GuzzleHttp\Client;

class Firewall
{
    public static $version = 'v1';

    public static $client = null;

    public static function getClient()
    {
        if (self::$client === null) {
            self::$client = $client = new Client([
                'base_uri' => 'https://api.vultr.com/' . self::$version . '/',
                'timeout'  => 10.0,
            ]);
        }

        return self::$client;
    }

    public static function request($type, $url, $get_pm = [], $post_pm = [])
    {
        try{
            $response = self::getClient()->request($type, $url . '?' . http_build_query($get_pm), [
                'headers'     => [
                    'API-Key' => config('vultr.vultr_api_key'),
                ],
                'form_params' => $post_pm,
            ]);

            return \GuzzleHttp\json_decode($response->getBody(), 1);

        }catch (\Exception $exception){
            return 403;
        }

    }

}