<?php
/**
 * Created by PhpStorm.
 * User: xuxu
 * Date: 2018/2/23
 * Time: 下午5:48
 */

namespace App\Helper;

class Response
{
    public static function vultr($res)
    {
        if (is_int($res)) {
            return response()->json((object)[])->setStatusCode($res);
        }

        return response(['data' => $res]);
    }
}