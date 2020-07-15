<?php

class SampleModel
{
    protected $table = 'test';
    protected $db;

    public function __construct()
    {
        $this->db = Yaf_Registry::get('db');
    }

    public function selectSample()
    {
        $user = $this->db->select($this->table, ['name'], ['id[>=]' => 1]);
        return $user;
    }

    public function insertSample($arrInfo)
    {
        return true;
    }
}
