<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;
use App\Teacher;
use App\Course;
use App\Day;
use App\Slot;
use App\Room;
use DB;
use App\Routine;

class RoutineController extends Controller{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $sections = Section:: get();
        $teachers = Teacher:: get();
        $courses = Course:: get();
        $routines = Routine::with(['teacher','course','section','room','day','slot'])->get();
        return view('routines',compact('sections','teachers','courses','routines'));
    }
    // function arraycount($array, $value){
    //     $counter = 0;
    //     foreach($array as $thisvalue) /*go through every value in the array*/
    //      {
    //            if($thisvalue === $value){ /*if this one value of the array is equal to the value we are checking*/
    //            $counter++; /*increase the count by 1*/
    //            }
    //      }
    //      return $counter;
    //      }
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
        $roomId;
        $dayId;
        $slotId;
        // condtions to assign room, day adn slot will be here
        $routines=Routine:: get();
        $days=Day:: get();
        $slots=Slot:: get();
        $rooms=Room:: get();
        // $days['days'] = DB::table('days')->get();
        // $slots['slots'] = DB::table('slots')->get();
        // $rooms['rooms'] = DB::table('rooms')->get();
        $sectionCount = 0;
        $teacherCount = 0;
        if (count($routines)>0){
                foreach($days as $day){
                    foreach ($routines as $item) {
                        if ($item->sectionId == $sectionId && $item->dayId == $day->id) {
                            $sectionCount++;
                        }
                        if ($item->teacherId == $teacherId && $item->dayId == $day->id) {
                                $teacherCount++;
                        }
                    }
                    if($teacherCount==3 || $sectionCount==3){
                        break;
                    }
                    $sectionCount = 0;
                    $teacherCount = 0;
                }
                if($teacherCount<3 && $sectionCount<3){
                    foreach($days as $day){
                        foreach($slots as $slot){
                            foreach($rooms as $room){
                                foreach ($routines as $item) {
                                    if($item->dayId == $day->id && $item->slotId == $slot->id && $item->roomId==$room->id && $item->sectionId==$sectionId){
                                        continue;
                                    }else{
                                        $roomId=$room->id;
                                        $dayId=$day->id;
                                        //dd($slot->id);
                                        $slotId=$slot->id;
                                        $assign=array('courseId'=>$courseId,'teacherId'=>$teacherId,'sectionId'=>$sectionId,'roomId'=>$roomId,'dayId'=>$dayId,'slotId'=>$slotId);
                                        DB::table('routines')->insert($assign);
                                        $request->session()->flash('alert-success', 'Successfully assigned!');
                                        return redirect()->route("routines");
                                    }
                                }
                            }
                        }
                    }
                }
            }else{
                foreach($days as $day){
                    foreach($slots as $slot){
                        foreach($rooms as $room){
                            $roomId=$room->id;
                            $dayId=$day->id;
                            $slotId=$slot->slotNo;                    
                            $assign=array('courseId'=>$courseId,'teacherId'=>$teacherId,'sectionId'=>$sectionId,'roomId'=>$roomId,'dayId'=>$dayId,'slotId'=>$slotId);
                            DB::table('routines')->insert($assign);
                            $request->session()->flash('alert-success', 'Successfully assigned!');
                            return redirect()->route("routines");
                        }                        
                    }
                }
            }
        // $assign=array('courseId'=>$courseId,'teacherId'=>$teacherId,'sectionId'=>$sectionId,'roomId'=>$roomId,'dayId'=>$dayId,'slotId'=>$slotId);
        // DB::table('routines')->insert($assign);
        // $request->session()->flash('alert-success', 'Successfully assigned!');
        // return redirect()->route("routines");
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
    
        public function deleteRoutine($id){
            $data=Routine::find($id);
            Routine::destroy($id);
            return redirect()->route("routines")->with('flash_message', 'Roolbacked your Assign!');
        }
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
