<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;
use App\Teacher;
use App\Course;
use DB;
use App\Routine;

class RoutineController extends Controller{
    public function index(){
        $sections = Section:: get();
        $teachers = Teacher:: get();
        $courses = Course:: get();
        $routines = Routine::with(['teacher','course','section'])->get();
        return view('routines',compact('sections','teachers','courses','routines'));
    }

    public function insertRoutine(Request $request){
        $this->validate($request,[
             'courseId'=>'required|max:255',
             'teacherId'=>'required|max:255',
             'sectionId'=>'required|max:255',
             'roomId'=>'nullable|max:255',
             'dayId'=>'nullable|max:255',
             'slotId'=>'nullable|max:255',
        ]);
        $courseId = $request->input('courseId');
        $teacherId = $request->input('teacherId');
        $sectionId = $request->input('sectionId');
        // condtions to assign room, day adn slot will be here
        $assign=array('courseId'=>$courseId,'teacherId'=>$teacherId,'sectionId'=>$sectionId);
        DB::table('routines')->insert($assign);
        $request->session()->flash('alert-success', 'Successfully assigned!');
        return redirect()->route("routines");
        }
        // public function editAssign($id) {
        //     $sections = DB::table('sections')->get();
        //     $assigns=Assign:: get();
        //     $teachers = Teacher:: get();
        //     $courses = Course:: get();
        //     $assignEditInfo = Assign::with(['teacher','course','section'])->find($id);
        //     // dd($groupData);
        //     return view('sections',compact('assigns','assignEditInfo','sections','teachers','courses'));
        // }
    
        // public function deleteAssign($id){
        //     $data=Assign::find($id);
        //     Assign::destroy($id);
        //     return redirect()->route("sections")->with('flash_message', 'Roolbacked your Assign!');
        // }
        // public function updateAssign(Request $request, $id){
        //     $courseId = $request->input('courseId');
        //     $teacherId = $request->input('teacherId');
        //     $sectionId = $request->input('sectionId');
        //     $assign=array('courseId'=>$courseId,'teacherId'=>$teacherId,'sectionId'=>$sectionId);
        //     Assign::where('id',$id)->update($assign);
        //     $request->session()->flash('alert-success', 'successfully Updated!');
        //     return redirect()->route("sections");
        //     }

}
