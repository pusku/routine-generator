<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Slot;
use DB;
class SlotController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $data['data'] = DB::table('slots')->get();
        $slotData['slotData']=DB::table('slots')->get();
        return view('slots',$data,$slotData);
    }
   
    public function insertSlot(Request $request){
        $this->validate($request,[
            'slotNo'=>'required|max:255|unique:slots',
            'startTime'=>'required|max:255',
            'endTime'=>'required|max:255',
            'type'=>'required|max:255',
        ]);
        $slotNo = $request->input('slotNo');
        $startTime = $request->input('startTime');
        $endTime = $request->input('endTime');
        $type = $request->input('type');
        $data=array('slotNo'=>$slotNo,'startTime'=>$startTime,'endTime'=>$endTime,'type'=>$type);
        DB::table('slots')->insert($data);
        $request->session()->flash('alert-success', 'Slot was successful added!');
        return redirect()->route("slots");
    }

    public function editSlot($id) {
        $data = DB::table('slots')->get();
        $slotData=DB::table('slots')->get();
        $slotEditInfo = Slot::find($id);
        // dd($groupData);
        return view('slots',compact('data','slotData','slotEditInfo'));
    }

    public function deleteSlot($id){
        $data=Slot::find($id);
        Slot::destroy($id);
        return redirect()->route("slots")->with('flash_message', 'Slot deleted!');
    }
    public function updateSlot(Request $request, $id){
        $slotNo = $request->input('slotNo');
        $startTime = $request->input('startTime');
        $endTime = $request->input('endTime');
        $type = $request->input('type');
        $data=array('slotNo'=>$slotNo,'startTime'=>$startTime,'endTime'=>$endTime,'type'=>$type);
        Slot::where('id',$id)->update($data);
        $request->session()->flash('alert-success', 'SLot was successful Updated!');
        return redirect()->route("slots");
        }
}