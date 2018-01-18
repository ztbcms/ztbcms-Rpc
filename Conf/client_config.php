<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

$client_config = [
    [
        'name' => '逸店主站',
        'alias' => 'yidian_www',
        'rpc_url' => '', //PRC链接呢
        'domain' => 'www.zhutibang.cn',
        'appid' => 'www.zhutibang.cn',
        'token' => 'zhutibang'
    ],
    [
        'name' => '逸店商城',
        'alias' => 'yidian_shop',
        'rpc_url' => 'http://ztbcms.biz:8888/index.php?g=Rpc&m=Rpc&a=call', //PRC链接呢
        'domain' => 'shop.zhutibang.cn',
        'appid' => 'shop.zhutibang.cn',
        'token' => 'zhutibang'
    ]
];

return [
    'client_config' => $client_config,
];



