<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Course;
use App\Section;
use App\Teacher;
use DB;
class CourseController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        // $data= DB::table('courses')->get();
        // $courseData=DB::table('courses')->get();
        $data = Course:: get();
        $sections = Section:: get();
        $teachers = Teacher:: get();
        $courseSection = Course::with('section')->get();
        return view('courses',compact('data','sections','courseSection','teachers'));
        // $data = Course:: get();
        // $courseData = Member:: get();
        //$courseSection = Expenses::with('section')->get();
        //return view('courses',$data,$courseData);
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

        /**
     * Store a newly created groupmember in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ctStore(Request $request){

        $Course = Course::find($request->courseId);
        $Course->member()->sync($request->memberId,false);
        Session::flash('success','Members are added to the group ');            
        return redirect()->back();
    }
    /**
     * Show the form for editing the specified groupmember.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function gmEdit($id)
    {
        $groups = Group:: get();
        $members = Member:: get();
        $groupWithMembers = Group::with('member')->get();
        $gmEditInfo = Group::with('member')->find($id);
        return view('groupCreateOrEdit',compact('groups','members','groupWithMembers','gmEditInfo'));
    }

    /**
     * Update the specified groupmember in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function gmUpdate(Request $request, $id)
    {
        //dd($request);
        if($request->previousSelectedGroupId != $request->groupId){
            $Group=Group::find($request->previousSelectedGroupId);
            $Group->member()->detach($request->memberId,false);
        }
        $Group=Group::find($request->groupId);
        $Group->member()->sync($request->memberId,false);
        Session::flash('success','Group member associations updated ');            
        return redirect()->route("group_create");
    }
}
