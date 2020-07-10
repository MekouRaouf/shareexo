<?php

namespace shareexo\Support\Storage;

use Countable;
use Shareexo\Support\Storage\Contracts\StorageInterface;

class SessionStorage implements StorageInterface, Countable{

    protected $bucket;

    public function __construct($bucket = 'default')
    {

        if(!isset($_SESSION[$bucket])){
            $_SESSION[$bucket] = [];
        }

        $this->bucket = $bucket;
    }

    public function set($index, $value)
    {
        $_SESSION[$this->bucket][$index] = $value;
    }

    public function exists($index)
    {
        return isset($_SESSION[$this->bucket][$index]);
    }

    public function get($index)
    {
        if(!$this->exists($index)){
            return null;
        }

        return $_SESSION[$this->bucket][$index];
    }

    public function all()
    {
        return $_SESSION[$this->bucket];
    }

    public function clear()
    {
        unset($_SESSION[$this->bucket]);
    }

    public function count():int
    {
        return count($this->all());
    }

}