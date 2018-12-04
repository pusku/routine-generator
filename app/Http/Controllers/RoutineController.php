<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;
use App\Teacher;
use App\Course;
use App\Routine;

class RoutineController extends Controller{
    public function index(){
        $sections = Section:: get();
        $teachers = Teacher:: get();
        $courses = Course:: get();
        $routines = Routine::with(['teacher','course','section'])->get();
        return view('routines',compact('sections','teachers','courses','routines'));
    }
}
