<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Routine extends Model{
    protected $table = 'routines';
    public function section(){
        return $this->belongsTo('App\Section','sectionId','id');
    }
    public function teacher(){
        return $this->belongsTo('App\Teacher','teacherId','id');
    }
    public function course(){
        return $this->belongsTo('App\Course','courseId','id');
    }
    public function room(){
        return $this->belongsTo('App\Room','roomId','id');
    }
    public function day(){
        return $this->belongsTo('App\Day','dayId','id');
    }
    public function slot(){
        return $this->belongsTo('App\Slot','slotId','id');
    }
}
