<?php

namespace Queue;

//队列生产者
class Task
{
    protected $redis;
    protected $queue_name;

    public function __construct()
    {
        //获取框架配置
        $config = \Yaf_Registry::get('config');

        //队列名
        $this->queue_name = $config->queue->name;

        //是否有连接redis
        $redis = \Yaf_Registry::get('redis');
        if (!empty($redis)) {
            $this->redis = $redis; //直接调用已连接的redis
        } else {
            $this->redis = \Init::initRedis(); //连接redis
        }
    }

    //添加任务
    public function task($task_name, $data, $delay = null)
    {
        //将任务和参数转成字符串
        $task = $this->taskData($task_name, $data, $delay);

        //往队列添加任务
        if (empty($delay)) {
            $this->addTask($task);
        } else {
            $this->addDelayTask($task, $delay);
        }

        return true;
    }

    //普通队列添加任务
    public function addTask($task)
    {
        return $this->redis->lpush($this->queue_name, $task);
    }

    //延时队列添加任务
    public function addDelayTask($task, $delay)
    {
        return $this->redis->zAdd(
            $this->queue_name . 'Delay',
            time() + $delay,
            $task
        );
    }

    //要执行的方法和数据拼装
    public function taskData($task_name, $data, $delay)
    {
        $param = (object)[];
        $param->task_name = $task_name;
        $param->data = $data;

        //延时队列，生成个唯一参数,防止覆盖掉旧value
        if (!empty($delay)) {
            $param->uniqid = uniqid(mt_rand(), true);
        }

        return json_encode($param);
    }
}