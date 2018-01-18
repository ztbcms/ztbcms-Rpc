<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Rpc\Service;

use JsonRPC\Server;
use Rpc\Api\ServerRpcApi;
use System\Service\BaseService;

class RpcService extends BaseService {

    /**
     * 启动PRC服务端
     */
    function server(){
        $rpc_config = $this->getServerConfig();

        $server = new Server();

        $authentication = [];
        foreach ($rpc_config['server_config'] as $index => $config){
            $authentication[$config['appid']] = $config['token'];
        }
        $server->authentication($authentication);

        $procedureHandler = $server->getProcedureHandler();
        $procedureHandler->withObject(new ServerRpcApi());

        $res = $server->execute();
        echo $res;
        exit();
    }

    /**
     * 获取RPC服务端配置
     * @return mixed
     */
    private function getServerConfig(){
        $rpc_config = require APP_PATH . 'Rpc/Conf/server_config.php';
        return $rpc_config;
    }

    /**
     * 获取RPC入口链接
     *
     * @return string
     */
    function server_url(){
        $ishttps = $_SERVER['SERVER_PORT'] == 443 || (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off') || strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) == 'https' || strtolower($_SERVER['HTTP_X_CLIENT_SCHEME']) == 'https' ? true : false;

        $url = $ishttps ? 'https://' : 'http://';
        $url .= $_SERVER['HTTP_HOST'];
        return $url . '/index.php?g=Rpc&m=Rpc&a=call';
    }

    /**
     * 客户端请求
     *
     * @param       $server_alias
     * @param       $service_name
     * @param array $params
     * @return array|mixed
     */
    function client($server_alias, $service_name, $params = []){
        $rpc_config = $this->getClientConfig();

        $client_config = $this->getClientByAlias($rpc_config['client_config'], $server_alias);
        if(empty($client_config)){
            return [
                'status' => false,
                'code' => 404,
                'msg' =>  '找不到RPC配置',
                'data' => null
            ];
        }

        $server_url = $client_config['rpc_url'];

        $client = new \JsonRPC\Client($server_url);

        $username = $client_config['appid'];
        $password = $client_config['token'];
        $client->getHttpClient()->withUsername($username)->withPassword($password);
        //debug,see php.ini配置的error.log
//        $client->getHttpClient()->withDebug();
        try{
            $result = $client->execute($service_name, $params);
        }catch (\Exception $e){
            $result = [
                'status' => false,
                'code' => 400,
                'msg' =>  $e->getMessage(),
                'data' => null
            ];
        }

        return $result;
    }

    /**
     * 获取RPC客户端
     * @return mixed
     */
    private function getClientConfig(){
        $rpc_config = require APP_PATH . 'Rpc/Conf/client_config.php';
        return $rpc_config;
    }

    /**
     * 根据服务的别名获取配置
     * @param $client_configs
     * @param $server_alias
     * @return null
     */
    private function getClientByAlias($client_configs, $server_alias){
        foreach ($client_configs as $index => $config){
            if($config['alias'] == $server_alias){
                return $config;
            }
        }

        return null;
    }


}