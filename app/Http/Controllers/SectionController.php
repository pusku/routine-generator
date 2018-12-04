<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Section;
use App\Teacher;
use App\Course;
use App\Assign;
use DB;
class SectionController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $sections = Section:: get();
        // $teachers = Teacher:: get();
        // $courses = Course:: get();
       // $assigns = Assign::with(['teacher','course','section'])->get();
        return view('sections',compact('sections'));
    }
   
    public function insertSection(Request $request){
        $this->validate($request,[
            'name'=>'required|max:255',
            //'semester'=>'required|max:255',
        ]);
        $name = $request->input('name');
        //$semester = $request->input('semester');
        $data=array('name'=>$name);
        DB::table('sections')->insert($data);
        $request->session()->flash('alert-success', 'Section was successful added!');
        return redirect()->route("sections");
    }

    public function editSection($id) {
        $sections = DB::table('sections')->get();
        // $assigns=Assign:: get();
        // $teachers = Teacher:: get();
        // $courses = Course:: get();
        $sectionEditInfo = Section::find($id);
        // dd($groupData);
        return view('sections',compact('sections','sectionEditInfo'));
    }

    public function deleteSection($id){
        $data=Section::find($id);
        Section::destroy($id);
        return redirect()->route("sections")->with('flash_message', 'Section deleted!');
    }
    public function updateSection(Request $request, $id){
        $name = $request->input('name');
        //$semester = $request->input('semester');
        $data=array('name'=>$name);
        Section::where('id',$id)->update($data);
        $request->session()->flash('alert-success', 'Sections was successful Updated!');
        return redirect()->route("sections");
        }
}