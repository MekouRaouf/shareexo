<?php

namespace Shareexo\History;

use Shareexo\Models\Solution;
use shareexo\Support\Storage\SessionStorage;

class SolutionHistory extends History{

    protected $solution;

    public function __construct(Solution $solution, SessionStorage $storage)
    {
        $this->solution = $solution;
        parent::__construct($storage);
    }

    public function add($solution)
    {
        $this->storage->set(count($this->storage->all()), $solution);
    }

    public function summary(){
        $items = [];

        foreach($this->storage->all() as $solution){
            $items[] = json_decode($solution);
        }

        return $items;
    }

}