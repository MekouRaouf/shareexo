<?php

namespace Shareexo\Support\Storage\Contracts;

interface StorageInterface{

    public function set($index, $value);
    public function exists($index);
    public function get($index);
    public function all();
    public function clear();

}