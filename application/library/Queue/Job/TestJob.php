<?php

namespace Queue\Job;

class TestJob
{
    protected $ao;
    protected $bb;

    public function __construct($data)
    {
        $this->ao = $data->ao;
        $this->bb = $data->bb;
    }

    public function handle()
    {
        echo $this->ao . ' ' . $this->bb . now().PHP_EOL;
    }
}