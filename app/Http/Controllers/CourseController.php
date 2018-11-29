<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Course;
use DB;
class CourseController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $data['data'] = DB::table('courses')->get();
        $courseData['courseData']=DB::table('courses')->get();
        return view('courses',$data,$courseData);
    }
    public function insertCourse(Request $request){
        $this->validate($request,[
            'name'=>'required|max:255',
            'type'=>'required|max:255',
            'credit'=>'nullable|max:255',
            'semester'=>'required|max:255',
        ]);
        $name = $request->input('name');
        $type = $request->input('type');
        $credit = $request->input('credit');
        $semester = $request->input('semester');
        $data=array('name'=>$name,'type'=>$type,'credit'=>$credit,'semester'=>$semester);
        DB::table('courses')->insert($data);
        $request->session()->flash('alert-success', 'Course was successful added!');
        return redirect()->route("courses");
    }

    public function editCourse($id) {
        $data = DB::table('courses')->get();
        $courseData=DB::table('courses')->get();
        $courseEditInfo = Course::find($id);
        // dd($groupData);
        return view('courses',compact('data','courseData','courseEditInfo'));
    }

    public function deleteCourse($id){
        $data=Course::find($id);
        Course::destroy($id);
        return redirect()->route("courses")->with('flash_message', 'Course deleted!');
    }
    public function updateCourse(Request $request, $id){
        $name = $request->input('name');
        $type = $request->input('type');
        $credit = $request->input('credit');
        $semester = $request->input('semester');
        $data=array('name'=>$name,'type'=>$type,'credit'=>$credit,'semester'=>$semester);
        Course::where('id',$id)->update($data);
        $request->session()->flash('alert-success', 'Course was successful Updated!');
        return redirect()->route("courses");
        }
}
