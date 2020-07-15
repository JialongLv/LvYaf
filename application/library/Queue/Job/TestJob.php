<?php

namespace Queue\Job;

class TestJob
{
    protected $ao;
    protected $bb;

    public function __construct($data)
    {
        $this->hello = $data->hello;
        $this->world = $data->world;
    }

    public function handle()
    {
        echo $this->hello . ' ' . $this->world . now().PHP_EOL;
    }
}