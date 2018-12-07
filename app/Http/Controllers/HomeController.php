<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slot;
use App\Day;
use App\Room;
use App\Routine;
use App\Section;
use App\Teacher;
use App\Course;
use DB;
use Auth;
class HomeController extends Controller{
    public function index()
    {
        return view('auth/login');
    }
    public function admin()
    {
        if (Auth::check()) {
            $slots = DB::table('slots')->get();
            $days = DB::table('days')->get();
            $rooms = DB::table('rooms')->get();
           // $routine = Routine::where('status','In Progress')->get();
            $routines = Routine::with(['teacher','course','section','room','day','slot'])->get();
            $roomCount=Room::Count();
            return view('index',compact('slots','days','rooms','roomCount','routines'));
        }
        else{
            return view('auth/login');
        }

    }
}
