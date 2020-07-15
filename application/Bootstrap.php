<?php

/**
 * @name Bootstrap
 * @author desktop-ra0k52u\ljl
 * @desc 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * @see http://www.php.net/manual/en/class.yaf-bootstrap-abstract.php
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
class Bootstrap extends Yaf_Bootstrap_Abstract
{

    public function _initConfig()
    {
        //把配置保存起来
        $config = Yaf_Application::app()->getConfig();
        Yaf_Registry::set('config', $config);

        //数据库连接
        $db = new \Medoo\Medoo([
            'database_name' => $config->db->database,
            'server' => $config->db->host,
            'username' => $config->db->user,
            'password' => $config->db->password,
            'port' => $config->db->port,
            'database_type' => 'mysql',
            'charset' => 'utf8mb4'
        ]);
        Yaf_Registry::set('db', $db);

        //Redis连接
//        $redis = new Redis();
//        $redis->connect($config->redis->host, $config->redis->port);
//        $redis->auth($config->redis->password);
//        $redis->select(0);//选择数据库0
//        Yaf_Registry::set('redis', $redis);
    }


    //初始化日志
    public function _initLog()
    {
        Yaf_Loader::import("Log/SeaLog.php");
        SeaLog::setBasePath();
        SeaLog::setLogger();
    }

    //加载通用函数
    public function _initCommon()
    {
        Yaf_Loader::import("Common.php");
    }

    public function _initPlugin(Yaf_Dispatcher $dispatcher)
    {
        //注册一个插件
        $objSamplePlugin = new SamplePlugin();
        $dispatcher->registerPlugin($objSamplePlugin);
    }

    public function _initRoute(Yaf_Dispatcher $dispatcher)
    {
        //在这里注册自己的路由协议,默认使用简单路由
    }

    public function _initView(Yaf_Dispatcher $dispatcher)
    {
        //在这里注册自己的view控制器，例如smarty,firekylin
        Yaf_Dispatcher::getInstance()->disableView();
    }
}
