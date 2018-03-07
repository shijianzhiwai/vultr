<?php
/**
 * vultr配置文件
 */

return [
    'vultr_api_key' => env('VULTR_API_KEY'),

    'port' => [
        443   => 'HTTPS',
        80    => 'HTTP',
        57483 => 'SSR',
        22    => 'SSH',
    ],
];

