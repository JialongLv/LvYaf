<?php

/**
 * @name ErrorController
 * @desc 错误控制器, 在发生未捕获的异常时刻被调用
 * @see http://www.php.net/manual/en/yaf-dispatcher.catchexception.php
 * @author desktop-ra0k52u\ljl
 */
class ErrorController extends Yaf_Controller_Abstract
{

    //从2.1开始, errorAction支持直接通过参数获取异常
    public function errorAction($exception)
    {
        switch ($exception->getCode()) {

            case YAF_ERR_NOTFOUND_MODULE:
            case YAF_ERR_NOTFOUND_CONTROLLER:
            case YAF_ERR_NOTFOUND_ACTION:
            case YAF_ERR_NOTFOUND_VIEW:
                echo json_encode([
                    'code' => 404,
                    'message' => '您访问的地址不存在'
                ]);
                break;
            case 10001:
                echo json_encode([
                    'code' => 10001,
                    'message' => $exception->getMessage()
                ]);
                break;
            default :
                SeaLog::error($exception->getMessage());
                echo json_encode([
                    'code' => 10002,
                    'message' => '系统内部错误'
                ]);
                break;
        }

        return true;
    }
}
