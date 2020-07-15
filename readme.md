LvYaf
===

## 目录
- 框架介绍
- 运行环境
- 代码结构
- 队列介绍
- 验证器介绍


## 框架介绍
在鸟哥的Yaf框架基础上，封装的一套符合自己个人开发习惯的一套API开发框架
该框架由4层架构成，Controller、Model、Service，Validate，优点如下：

1、框架层次分明，结构清晰、使用简洁（开箱即用）、功能强大。

2、基于 yaf 框架和 SeasLog 扩展，两者都是C语言扩展，保证了性能。

3、集成Medoo， Medoo是简洁强大的数据库 ORM 框架，简洁易用，安全可靠。具体参考 https://medoo.in/doc

4、在Yaf的基础上集成日志模块、公用函数模块、数据验证层等。

5、高性能队列模块，自己造的队列轮子，简单易用，性能好。


## 运行环境

运行环境： PHP 7 

依赖扩展： yaf 、phpredis、SeasLog 扩展 

yaf 介绍以及安装： https://github.com/laruence/yaf

SeasLog 介绍以及安装： https://github.com/SeasX/SeasLog

SeasLog 介绍以及安装：https://github.com/phpredis/phpredis

## 代码结构
```php
———————————————— 
|--- application              //业务代码 
     |----- controller    //控制器目录
                |------ User.php    //User控制器
	 |----- library           //公共类库目录
         |----- Assert        //验证器目录
         |----- Log           //写日志目录
         |----- Medoo         //ORM目录
         |----- Services      //Service业务层目录
         |----- Validates     //数据验证层目录    
         |----- Queue         //队列目录
            |----- Job              //队列任务目录
              
     |----- models           //模型层     
     |----- plugins            //yaf插件目录，路由前后钩子，(接口验签，登录校验，权限检验可写在这里)
     |----- modules           //模块目录，配置多模块用到     
     |----- views            //视图层
|--- conf                     //yaf配置路径          
|--- logs                     //日志文件 
|--- public                   //入口器目录
|--- vendor                   //composer引入的第三方包
```

## 队列介绍

###  源起
网上找了一圈，没找到自己满意的队列composer包，就在自己造了个轮子，集成进来。

###  使用
代码示例
```php

    /**
    * 添加队列任务
    * @param string table 任务名称
    * @param array data   执行任务需要的参数
    * @param delay int    延时执行时间，可空
    */
    public function task($task_name, $data, $delay);

    //示例
	public static function taskExample() {
		$task = new \Queue\Task();
        $task->task('TestJob', ['hello' => 'hello', 'world' => 'world'], 15);
	}
```

队列监听

library/Queue文件夹下执行  php Worker.php

生产环境下要开启守护进程，建议使用supervisord


##  验证器介绍

###  源起
在代码中默认不信任用户输入的数据，对用户输入的数据做验证，验证器便是把对用户验证从控制器中分离出来。

###  使用

具体使用方法参考https://github.com/webmozart/assert

代码示例
```php

    //示例
    public static function  hello($request)
    {
        Assert::integer($request->getParam('a'));

        //Assert::isArray($request->getParam('a','a必须为数组'));
    }
```





