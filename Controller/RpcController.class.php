<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Rpc\Controller;

use Common\Controller\Base;
use JsonRPC\Response\ResponseBuilder;
use Rpc\Service\RpcService;

/**
 * Class RpcController
 */
class RpcController extends Base {

    /**
     * RPC服务调用入口
     */
    function call(){
        //是否启动RPC
        if(!C('RPC_OPEN')){
            $response = ResponseBuilder::create()
                ->withId(time())
                ->withResult('')
                ->withError(403, 'RPC server is close.', '')
                ->build();

            echo $response;
            exit();
        }
        $rpcService = new RpcService();
        $rpcService->server();
    }

}