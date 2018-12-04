<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model{
    protected $table = 'slots';
    public function routine(){
        return $this->hasMany('App\Routine', 'id', 'slotId');
    }
}
