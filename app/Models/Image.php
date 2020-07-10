<?php

namespace Shareexo\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model{

    protected $fillable = [
        'name',
    ];

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function solution(){
        return $this->belongsTo(Solution::class);
    }

}