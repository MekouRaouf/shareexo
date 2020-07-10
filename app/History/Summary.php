<?php

namespace Shareexo\History;

class Summary{

    protected $type;
    protected $subject;
    protected $description;
    protected $slug;
    protected $link;
    protected $created;
    protected $updated;

    public function __construct($type, $subject = null, $description, $slug, $link, $created, $updated){
        $this->type = $type;
        $this->subject = $subject;
        $this->description = $description;
        $this->slug = $slug;
        $this->link = $link;
        $this->created = $created;
        $this->updated = $updated;
    }

    public function subject(){
        return $this->subject;
    }

    public function slug(){
        return $this->slug;
    }
    public function type(){
        return $this->type;
    }
    public function description(){
        return $this->description;
    }
    public function link(){
        return $this->link;
    }
    public function date(){
        return $this->created;
    }

}