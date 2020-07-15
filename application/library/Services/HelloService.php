<?php

namespace Services;

class HelloService
{
    public function hello()
    {
        //模型层
        $test = new \SampleModel();
        $test->selectSample();
    }
}