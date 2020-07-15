<?php
/**
 * @name SamplePlugin
 * @desc Yaf定义了如下的6个Hook,插件之间的执行顺序是先进先Call
 * @see http://www.php.net/manual/en/class.yaf-plugin-abstract.php
 * @author desktop-ra0k52u\ljl
 */
class SamplePlugin extends Yaf_Plugin_Abstract {

    //在路由之前触发
	public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {

	}

	//路由结束之后触发
	public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
	    //登录校验 or 用户权限校验
	    $login = [
	        '/api/hello/hello'
        ];

//	    if (in_array($request->uri,$login )){
//            throw new Exception("111w",1111);
//        }

	}

	//分发循环开始之前被触发
	public function dispatchLoopStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {

	}

	//分发之前触发
	public function preDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
	}

	//分发结束之后触发
	public function postDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
	}

	//发循环结束之后触发
	public function dispatchLoopShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {

	}
}
