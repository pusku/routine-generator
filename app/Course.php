<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Section;
class Course extends Model
{
    protected $table = 'courses';
    public $timestamps = false;
    public function section()
    {
        return $this->hasMany('App\Section','semester','semester');
    }
}
