<?php

namespace App\Helper;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Request
{
    /**
     * @param $pm
     * @param $rule
     * @return array
     * @throws ValidationException
     */
    public static function validator($pm, $rule)
    {
        $default = [];
        foreach ($rule as $key => &$value) {
            if (is_array($value)) {
                if (!in_array('required', $value)) {
                    $c = count($value) - 1;
                    $default[$key] = $value[$c];
                    unset($value[$c]);
                }
            } else {
                $e = explode('@', $value);
                if (isset($e[1])) {
                    $default[$key] = $e[1];
                }
                $value = $e[0];
            }
        }

        $validator = Validator::make($pm, $rule);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return array_merge($default, $validator->valid());
    }
}