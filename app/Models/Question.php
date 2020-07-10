<?php

namespace Shareexo\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model{

    protected $fillable = [
        'username',
        'useremail',
        'subject',
        'description',
        'slug',
        'link'
    ];

    public function solutions(){
        return $this->hasMany(Solution::class);
    }

    public function images(){
        return $this->hasMany(Image::class, 'question_id');
    }
    
    public function question_last_id(){
        return $this->count(Question::class);
    }

}