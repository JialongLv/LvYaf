<?php
//Yaf_Loader::getInstance()->registerNamespace('Webmozart', __DIR__ . '/../../vendor/webmozart/assert/src');

class BaseController extends Yaf_Controller_Abstract
{

    protected $validate;

    public function returnJson($data = [], $code = 1000, $message = 'success')
    {
        echo json_encode(['code' => $code, 'message' => $message, 'data' => $data]);
        return true;
    }

    public function test($data = [], $code = 1000, $message = 'success')
    {
        echo json_encode(['code' => $code, 'message' => $message, 'data' => $data]);
        return true;
    }

}