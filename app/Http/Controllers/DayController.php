<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Day;
use DB;
class DayController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $data['data'] = DB::table('days')->get();
        $dayData['dayData']=DB::table('days')->get();
        return view('days',$data,$dayData);
    }
   
    public function insertDay(Request $request){
        $this->validate($request,[
            'day'=>'required|max:255',
        ]);
        $day = $request->input('day');
        $data=array('day'=>$day);
        DB::table('days')->insert($data);
        $request->session()->flash('alert-success', 'Day was successful added!');
        return redirect()->route("days");
    }

    public function editDay($id) {
        $data = DB::table('days')->get();
        $dayData=DB::table('days')->get();
        $dayEditInfo = Day::find($id);
        // dd($groupData);
        return view('days',compact('data','dayData','dayEditInfo'));
    }

    public function deleteDay($id){
        $data=Day::find($id);
        Day::destroy($id);
        return redirect()->route("days")->with('flash_message', 'Day deleted!');
    }
    public function updateDay(Request $request, $id){
        $day = $request->input('day');
        $data=array('day'=>$day);
        Day::where('id',$id)->update($data);
        $request->session()->flash('alert-success', 'Day was successful Updated!');
        return redirect()->route("days");
        }
}