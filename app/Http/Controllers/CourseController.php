<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Course;
use App\Section;
use App\Teacher;
use App\Routine;
use DB;
class CourseController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $data = Course:: get();
        $sections = Section:: get();
        $teachers = Teacher:: get();
        return view('courses',compact('data','sections','teachers'));
    }
    public function insertCourse(Request $request){
        $this->validate($request,[
            'name'=>'required|max:255',
            'type'=>'required|max:255',
            'credit'=>'nullable|max:255',
            
        ]);
        $name = $request->input('name');
        $type = $request->input('type');
        $credit = $request->input('credit');
        // $semester = $request->input('semester');
        $data=array('name'=>$name,'type'=>$type,'credit'=>$credit);
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
        //$semester = $request->input('semester');
        $data=array('name'=>$name,'type'=>$type,'credit'=>$credit);
        Course::where('id',$id)->update($data);
        $request->session()->flash('alert-success', 'Course was successful Updated!');
        return redirect()->route("courses");
        }
}
