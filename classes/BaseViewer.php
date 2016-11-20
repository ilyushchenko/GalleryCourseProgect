<?php
require_once 'DB.php';
require_once 'Auth.php';

class BaseViewer
{
    protected static $db;
    public function __construct()
    {
        $this->db = new DB();
    }
}