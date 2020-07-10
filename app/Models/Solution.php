<?php

namespace Shareexo\Models;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model{

    protected $fillable = [
        'username',
        'useremail',
        'description',
        'slug',
        'link',
    ];

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function images(){
        return $this->hasMany(Image::class, 'solution_id');
    }
    
    public function solution_last_id(){
        return $this->count(Solution::class);
    }

}