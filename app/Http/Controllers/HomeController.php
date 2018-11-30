<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slot;
use App\Day;
use DB;
class HomeController extends Controller{
    public function index(){
        $slots['slots'] = DB::table('slots')->get();
        $days['days'] = DB::table('days')->get();
        return view('index',$slots,$days);
    }
}
