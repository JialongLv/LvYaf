<?php
//队列消费者

//自定义捕捉异常
set_error_handler("func_error_handler");

//加载Yaf框架
define('APPLICATION_PATH', dirname(__FILE__) . '/../../..');
$application = new Yaf_Application(APPLICATION_PATH . "/conf/application.ini");
$application->bootstrap()->run();

//执行业务逻辑
$application->execute('main');

function main()
{
    $worker = new Worker();

    //队列监听和处理
    while (True) {
        $worker->queueHandler();
        $worker->delayQueueHandler();
        usleep(500000); //间隔0.5秒监听一次队列
    }
}

//捕获并抛出异常
function func_error_handler()
{
    throw new Exception(error_get_last()['message']);
}

class Worker
{
    protected $redis;
    protected $queue_name;

    //reids连接
    function __construct()
    {
        //获取配置
        $config = Yaf_Registry::get('config');

        //队列名字
        $this->queue_name = $config->queue->name;

        //连接redis
        $redis = new Redis();
        $redis->connect($config->redis->host, $config->redis->port);
        $redis->auth($config->redis->password);
        $redis->select(0);//选择数据库0

        $this->redis = $redis;
    }

    //普通队列处理
    public function queueHandler()
    {
        //取出一个队列内的任务，并将任务从队列中删除
        $task = $this->redis->lpop($this->queue_name);

        if (!empty($task)) {
            $this->handleTask($task);//执行任务
            $this->queueHandler();//执行完队列任务后，再查看下队列内是否有任务，一并处理掉，防止堆积
        }

        return;
    }

    //延时队列处理
    public function delayQueueHandler()
    {
        //取出当前时间要执行的所有任务
        $task_list = $this->redis->zRangeByScore($this->queue_name . 'Delay', 0, time());

        if (!empty($task_list)) {
            foreach ($task_list as $task) {
                //将任务从队列中删除
                $this->redis->zRem($this->queue_name . 'Delay', $task);
                //执行任务
                $this->handleTask($task);
            }
            $this->delayQueueHandler(); //执行完队列任务后，再查看下队列内是否有任务，一并处理掉，防止堆积
        }

        return;
    }

    public function handleTask($task)
    {
        try {
            $task = json_decode($task);
            $className = '\\Queue\Job\\' . $task->task_name;
            $job = new $className($task->data); // 实例化队列任务
            $job->handle(); //执行任务
        } catch (Exception $e) {
            //异常任务存进数据库，以便排查
            db()->insert('fail_job', [
                'task_name' => $task->task_name, //任务名称
                'data' => $task->data,  //任务需要执行的数据
                'message' => $e->getMessage(), //错误信息
                'created_at' => now()
            ]);
            //异常写入日志
            SeaLog::error($e->getMessage());
        }

        return;
    }
}


