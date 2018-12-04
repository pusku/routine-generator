<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Teacher;
use DB;
class TeacherController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $data['data'] = DB::table('teachers')->get();
        $teacherData['teacherData']=DB::table('teachers')->get();
        return view('teachers',$data,$teacherData);
    }
    public function insertTeacher(Request $request){
        $this->validate($request,[
            'teacherId'=>'required|max:255|unique:teachers',
            'name'=>'required|max:255',
            'email'=>'nullable|max:255|unique:teachers',
            'phone'=>'required|max:255|unique:teachers',
            'initial'=>'required|max:255|unique:teachers',
            'offday'=>'nullable|max:255',
        ]);
        $teacherId = $request->input('teacherId');
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $initial = $request->input('initial');
        $offday = $request->input('offday');
        $data=array('teacherId'=>$teacherId,'name'=>$name,'email'=>$email,'phone'=>$phone,'initial'=>$initial,'offday'=>$offday);
        DB::table('teachers')->insert($data);
        $request->session()->flash('alert-success', 'Teacher was successful added!');
        return redirect()->route("teachers");
    }

    public function editTeacher($id) {
        $data = DB::table('teachers')->get();
        $teacherData=DB::table('teachers')->get();
        $teacherEditInfo = Teacher::find($id);
        // dd($groupData);
        return view('teachers',compact('data','teacherData','teacherEditInfo'));
    }

    public function deleteTeacher($id){
        $data=Teacher::find($id);
        Teacher::destroy($id);
        return redirect()->route("teachers")->with('flash_message', 'Teacher deleted!');
    }
    public function updateRoom(Request $request, $id){
        $teacherId = $request->input('teacherId');
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $initial = $request->input('initial');
        $offday = $request->input('offday');
        $data=array('teacherId'=>$teacherId,'name'=>$name,'email'=>$email,'phone'=>$phone,'initial'=>$initial,'offday'=>$offday);
        Teacher::where('id',$id)->update($data);
        $request->session()->flash('alert-success', 'Teacher was successful Updated!');
        return redirect()->route("teachers");
        }
}
