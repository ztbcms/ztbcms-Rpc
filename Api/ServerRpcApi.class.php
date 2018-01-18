<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Rpc\Api;

/**
 * 服务端的开放RPC接口
 * 你的所有接口应该都在这里注册
 */
class ServerRpcApi {

    //Ping接口，检测响应时间
    function ping($time){

        return ['status' => true, 'data' => [
            'request_time' => $time,
            'response_time' => time()
        ]];
    }

}