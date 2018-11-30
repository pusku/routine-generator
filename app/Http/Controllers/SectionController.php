<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Section;
use DB;
class SectionController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $data['data'] = DB::table('sections')->get();
        $sectionData['sectionData']=DB::table('sections')->get();
        return view('sections',$data,$sectionData);
    }
   
    public function insertSection(Request $request){
        $this->validate($request,[
            'name'=>'required|max:255',
            'semester'=>'required|max:255',
        ]);
        $name = $request->input('name');
        $semester = $request->input('semester');
        $data=array('name'=>$name,'semester'=>$semester);
        DB::table('sections')->insert($data);
        $request->session()->flash('alert-success', 'Section was successful added!');
        return redirect()->route("sections");
    }

    public function editSection($id) {
        $data = DB::table('sections')->get();
        $sectionData=DB::table('sections')->get();
        $sectionEditInfo = Section::find($id);
        // dd($groupData);
        return view('sections',compact('data','sectionData','sectionEditInfo'));
    }

    public function deleteSection($id){
        $data=Section::find($id);
        Section::destroy($id);
        return redirect()->route("sections")->with('flash_message', 'Section deleted!');
    }
    public function updateSection(Request $request, $id){
        $name = $request->input('name');
        $semester = $request->input('semester');
        $data=array('name'=>$name,'semester'=>$semester);
        Section::where('id',$id)->update($data);
        $request->session()->flash('alert-success', 'Sections was successful Updated!');
        return redirect()->route("sections");
        }
}