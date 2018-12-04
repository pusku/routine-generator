<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model{
    protected $table = 'rooms';
    public function routine(){
        return $this->hasMany('App\Routine', 'id', 'roomId');
    }
}
