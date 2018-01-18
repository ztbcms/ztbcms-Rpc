<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Rpc\Controller;

use Common\Controller\Base;
use Rpc\Service\RpcService;

class TestController extends Base {


    function testServer(){
        $rpc = new RpcService();

        $result = $rpc->client('yidian_shop','ping', ['time' => time()]);

        var_dump($result);
        exit();
    }

}