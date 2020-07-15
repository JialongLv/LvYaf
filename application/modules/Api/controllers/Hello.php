<?php

use Validates\Api\HelloValidate;

class HelloController extends BaseController
{

    public function init()
    {

    }

    //example
    public function helloAction()
    {
        //数据验证层
        HelloValidate::hello($this->getRequest());

        //业务逻辑层
        $hello = new \Services\HelloService();
        $user = $hello->hello();

        //普通队列,发邮件，发短信。 or 延时队列，30分钟取消订单等。
        $task = new \Queue\Task();
        $task->task('TestJob', ['hello' => 'hello', 'world' => 'world'], 15);

        return $this->returnJson(['data' => 'Hello Word']);
    }
}
