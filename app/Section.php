<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'sections';
    public function routine(){
        return $this->hasMany('App\Routine', 'id', 'sectionId');
    }
}
