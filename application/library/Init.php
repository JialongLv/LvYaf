<?php


class Init
{
    //Redis连接
    public static function initRedis()
    {

        $config = \Yaf_Registry::get('config');

        $redis = new \Redis();
        $redis->connect($config->redis->host, $config->redis->port);
        $redis->auth($config->redis->password);
        $redis->select(0);//选择数据库0
        \Yaf_Registry::set('redis', $redis);

        return $redis;
    }
}