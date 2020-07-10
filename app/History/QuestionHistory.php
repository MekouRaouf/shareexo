<?php

namespace Shareexo\History;

use Shareexo\Models\Question;
use shareexo\Support\Storage\SessionStorage;

class QuestionHistory extends History{

    protected $question;

    public function __construct(Question $question, SessionStorage $storage)
    {
        $this->question = $question;
        parent::__construct($storage);
    }

    public function add($question)
    {
        $this->storage->set(count($this->storage->all()), $question);
    }

    public function summary(){
        $items = [];

        foreach($this->storage->all() as $question){
            $items[] = json_decode($question);
        }

        return $items;
    }

}