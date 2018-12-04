<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Course extends Model{
    protected $table = 'courses';
    public function routine(){
        return $this->hasMany('App\Routine', 'id', 'courseId');
    }
}
