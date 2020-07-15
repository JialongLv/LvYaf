<?php

use Validates\Api\HelloValidate;
/**
 * @name Hello
 * @author desktop-ra0k52u\ljl
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
class IndexController extends Yaf_Controller_Abstract
{
    /**
     * 默认初始化方法，如果不需要，可以删除掉这个方法
     * 如果这个方法被定义，那么在Controller被构造以后，Yaf会调用这个方法
     */
    public function init()
    {
        $this->getView()->assign("header", "Yaf Example");
    }

    /**
     * 默认动作
     * Yaf支持直接把Yaf_Request_Abstract::getParam()得到的同名参数作为Action的形参
     * 对于如下的例子, 当访问http://yourhost/yaf_skeleton/index/index/index/name/desktop-ra0k52u\ljl 的时候, 你就会发现不同
     */
    public function indexAction()
    {
        //数据验证层
        HelloValidate::hello($this->getRequest());

        //业务逻辑层
        $hello = new \Services\HelloService();
        $user = $hello->hello();

        //普通队列,发邮件，发短信。 or 延时队列，30分钟取消订单等。
        $task = new \Queue\Task();
        $task->task('TestJob', ['ao' => 'hello', 'bb' => 'world'], 15);

        return $this->returnJson(['data' => 'Hello Word']);
    }

}
