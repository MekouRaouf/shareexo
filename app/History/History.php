<?php

namespace Shareexo\History;

use Shareexo\Support\Storage\Contracts\StorageInterface;

class History{

    protected $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function all_history(){

        $items = [];

        foreach($this->storage->all() as $item){
            $data = json_decode($item, true);
            if(isset($data['subject'])){
                $items[] = new Summary('question', $data['subject'], $data['description'], $data['slug'], $data['link'], $data['created_at'], $data['updated_at']);
            } else {
                $items[] = new Summary('solutions', null , $data['description'], $data['slug'], $data['link'], $data['created_at'], $data['updated_at']);
            }
        }

        return $items;
    }
}