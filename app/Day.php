<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Day extends Model{
    protected $table = 'days';
    public function routine(){
        return $this->hasMany('App\Routine', 'id', 'dayId');
    }
}
