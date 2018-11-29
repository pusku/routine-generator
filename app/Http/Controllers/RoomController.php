<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Room;
use DB;
class RoomController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $data['data'] = DB::table('rooms')->get();
        $roomData['roomData']=DB::table('rooms')->get();
        return view('rooms',$data,$roomData);
    }
   
    public function insertRoom(Request $request){
        $this->validate($request,[
            'name'=>'required|max:255',
            'type'=>'required|max:255',
            'maintainer'=>'nullable|max:255',
            'phone'=>'required|max:255|unique:rooms',
        ]);
        $name = $request->input('name');
        $type = $request->input('type');
        $maintainer = $request->input('maintainer');
        $phone = $request->input('phone');
        $data=array('name'=>$name,'type'=>$type,'maintainer'=>$maintainer,'phone'=>$phone);
        DB::table('rooms')->insert($data);
        $request->session()->flash('alert-success', 'Room was successful added!');
        return redirect()->route("rooms");
    }

    public function editRoom($id) {
        $data = DB::table('rooms')->get();
        $roomData=DB::table('rooms')->get();
        $roomEditInfo = Room::find($id);
        // dd($groupData);
        return view('rooms',compact('data','roomData','roomEditInfo'));
    }

    public function deleteRoom($id){
        $data=Room::find($id);
        Room::destroy($id);
        return redirect()->route("rooms")->with('flash_message', 'Room deleted!');
    }
    public function updateRoom(Request $request, $id){
        $name = $request->input('name');
        $type = $request->input('type');
        $maintainer = $request->input('maintainer');
        $phone = $request->input('phone');
        $data=array('name'=>$name,'type'=>$type,'maintainer'=>$maintainer,'phone'=>$phone);
        Room::where('id',$id)->update($data);
        $request->session()->flash('alert-success', 'Room was successful Updated!');
        return redirect()->route("rooms");
        }
}