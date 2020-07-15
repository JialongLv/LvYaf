<?php

namespace Validates\Api;

use Assert\Assert;

class HelloValidate
{
    //数据验证逻辑
    public static function  hello($request)
    {
        Assert::integer($request->getParam('a'));

        //Assert::isArray($request->getParam('a','a必须为数组'));
    }
}