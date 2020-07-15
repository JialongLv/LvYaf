<?php
//全局通用函数

//获取当前时间
function now()
{
    return date('Y-m-d H:i:s');
}

//获取数据库
function db()
{
    return Yaf_Registry::get('db');
}