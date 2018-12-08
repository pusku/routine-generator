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

    //Function to count array's value
    function arraycount($array, $value){
        $counter = 0;
        foreach($array as $thisvalue) /*go through every value in the array*/
         {
               if($thisvalue === $value){ /*if this one value of the array is equal to the value we are checking*/
               $counter++; /*increase the count by 1*/
               }
         }
         return $counter;
    }

    // function to find offday of a teacher
    public function teacherDayoff($id){
        $offday = Teacher::select('offday')
        ->where('id','=', $id)
        ->first();
       // dd($offday);
        return $offday;
    }

    //function to count if teacher or section has already 3 class in a day
    public function counter($id, $sectionId, $teacherId){
        $sectionCount = 0;
        $teacherCount = 0;
        $flag = 0;
        $routines = Routine:: get();
        foreach ($routines as $item) {
            if ($item->sectionId == $sectionId && $item->dayId == $id) {
                 $sectionCount++;
            }
            if ($item->teacherId == $teacherId && $item->dayId == $id) {
                 $teacherCount++;
            }
        }
        if($teacherCount==3 || $sectionCount==3){
            $flag=1;
        }
        return $flag;
    }

    // function to set 2 class per week if its a theory course, if its a lab it will assign one class in a week
    public function courseClassCounter($courseId, $sectionId){
        $courseCount = 0;
        $flag=0;
        $routines = Routine:: get();
        $data=Course::find($courseId);
        foreach ($routines as $item) {
            if ($item->sectionId == $sectionId && $item->courseId == $courseId) {
                 $courseCount++;
            }
            if($data->type == 'Theory' && $courseCount == 2){
                $flag=1;
            }
            if($data->type == 'Lab' && $courseCount == 2){
                $flag=1;
            }
        }
        return $flag;
    }
    // Function to check a course of a section per day
    public function courseForSectionPerDay($courseId, $sectionId, $dayId){
        $courseCount = 0;
        $flag=0;
        $routines = Routine:: get();
        //$data=Course::find($courseId);
        foreach ($routines as $item) {
            if ($item->sectionId == $sectionId && $item->courseId == $courseId && $item->dayId == $dayId) {
                 $courseCount++;
            }
        }
        if($courseCount == 1){
            $flag=1;
        }
        return $flag;
    }
    

    public function isThereAlreadyAclass($roomId, $slotId, $dayId){
        $courseCount = 0;
        $flag=0;
        $routines = Routine:: get();
        //$data=Course::find($courseId);
        foreach ($routines as $item) {
            if($item->dayId == $dayId && $item->slotId == $slotId && $item->roomId==$roomId){
                 $courseCount++;
            }
        }
        if($courseCount == 1){
            $flag=1;
        }
        return $flag;
    }

    public function isTisTeacherHasClassinThisSlot($teacherId, $slotId, $dayId){
        $courseCount = 0;
        $flag=0;
        $routines = Routine:: get();
        //$data=Course::find($courseId);
        foreach ($routines as $item) {
            if($item->teacherId == $teacherId && $item->dayId == $dayId && $item->slotId == $slotId){
                 $courseCount++;
            }
        }
        if($courseCount == 1){
            $flag=1;
        }
        return $flag;
    }
    public function classType($courseId){
        $ClassType = Course::select('type')
        ->where('id','=', $courseId)
        ->first();
       // dd($offday);
        return $ClassType;

    }

    public function lastClassofTeacher($dayId,$teacherId){
        $lastClassofTeacher = Routine::select('slotId')
        ->where('dayId','=', $dayId)->where('teacherId', '=', $teacherId)->orderBy('slotId', 'desc')->first();
    //   dd($lastClassofTeacher);
      //dd($lastClassofTeacher->slotId);
        return $lastClassofTeacher;

    }
    public function insertRoutine(Request $request){
        $this->validate($request,[
             'courseId'=>'required|max:255',
             'teacherId'=>'required|max:255',
             'sectionId'=>'required|max:255',
            //  'roomId'=>'nullable|max:255',
            //  'dayId'=>'nullable|max:255',
            //  'slotId'=>'nullable|max:255',
        ]);
        $courseId = $request->input('courseId');
        $teacherId = $request->input('teacherId');
        $sectionId = $request->input('sectionId');
        // $roomId;
        // $dayId;
        // $slotId;
        // condtions to assign room, day adn slot will be here
        $routines = Routine:: get();
        //with(['teacher','course','section','room','day','slot'])->get();
        $days=Day:: get();
        $slots=Slot:: get();
        $rooms=Room:: get();
        $teacherDayoff = RoutineController::teacherDayoff($teacherId);
        //dd();
        $one=1;
        $two=2;
        $courseCounter = RoutineController::courseClassCounter($courseId, $sectionId);
        $classType = RoutineController::classType($courseId);
        // dd($classType);
        // $days['days'] = DB::table('days')->get();
        // $slots['slots'] = DB::table('slots')->get();
        // $rooms['rooms'] = DB::table('rooms')->get();
        if (count($days)==0){
            echo "You have to add room first";
        }
        if (count($slots)==0){
            echo "you have to add slot first";
        }
        if (count($rooms)==0){
            echo "you have to add room before you can generate routine";
        }
        if (count($routines)>0){
            if($courseCounter == $one){
                echo 'You can not assign cause this course is alrady 2 times available in this week for this section';
                
            }else{
            foreach($days as $day){
                $counter = RoutineController::counter($day->id, $sectionId, $teacherId);
                $courseForSectionPerDay = RoutineController::courseForSectionPerDay($courseId, $sectionId,$day->id);
                $lastClassofTeacher = RoutineController::lastClassofTeacher($day->id,$teacherId);
                //dd($lastClassofTeacher->slotId);
                foreach($slots as $slot){
                    foreach($rooms as $room){
                        $isTisTeacherHasClassinThisSlot = RoutineController::isTisTeacherHasClassinThisSlot($teacherId,$slot->id,$day->id);
                        $isThereAlreadyAclass = RoutineController::isThereAlreadyAclass($room->id, $slot->id,$day->id);
                        $aa = Routine::select('teacherId')->where('teacherId','=', $teacherId)->where('dayId','=',$day->id)->first();
                        //dd($lastClassofTeacher->slotId);
                        if($isThereAlreadyAclass == $one){
                            break;
                        }
                        // else if(is_null($aa) || is_null($slot->id+1)){
                            
                        //     break;
                        // }else if($lastClassofTeacher->slotId == $slot->id-1 || $lastClassofTeacher->slotId == $slot->id+1){
                                
                        //         break;
                        //     }
                        foreach ($routines as $item) {
                            if($isThereAlreadyAclass == $one){
                                break;
                            }
                            else if($teacherDayoff->offday == $day->day){
                                break;
                            }
                           
                            else if($courseForSectionPerDay == $one){
                                break;
                            }
                            else if($counter == $one){
                                break;
                            }else if($isTisTeacherHasClassinThisSlot == one){
                                break;
                            }
                            else if($classType->type == "Lab"){
                                $b=0;
                                while($b<2){
                                    
                                    $roomType=$room->type;
                                    if($roomType=="Theory"){
                                        foreach($rooms as $room){
                                            if($room->type=="Lab"){
                                                $roomId=$room->id;
                                            }
                                        }
                                    }else{
                                        $roomId=$room->id;
                                    }
                                    $dayId=$day->id;
                                    if($b==0){
                                        $slotId=$slot->id;
                                    }if($b==1){
                                        $slotId=$slot->id+1;
                                        $isThereAlreadyAclass = RoutineController::isThereAlreadyAclass($room->id, $slotId,$day->id);
                                        while(!empty($isThereAlreadyAclass)){
                                            $slotId++;
                                            $isThereAlreadyAclass = RoutineController::isThereAlreadyAclass($room->id, $slotId,$day->id);
                                        }    
                                    }
                                    $assign=array('courseId'=>$courseId,'teacherId'=>$teacherId,'sectionId'=>$sectionId,'roomId'=>$roomId,'dayId'=>$dayId,'slotId'=>$slotId);
                                    DB::table('routines')->insert($assign);
                                    $b++;
                                }
                                return redirect()->route("routines");
                            }else if($classType->type == "Theory"){
                                $b=0;
                                while($b<2){
                                   // $roomId=$room->id;
                                    $roomType=$room->type;
                                    if($roomType=="Lab"){
                                        foreach($rooms as $room){
                                            if($room->type=="Theory"){
                                                $roomId=$room->id;
                                            }
                                        }
                                    }else{
                                        $roomId=$room->id;
                                    }
                                    $slotId=$slot->id;
                                    if($b==0){
                                        $dayId=$day->id;
                                    }if($b==1){
                                        $dayId=$day->id+1;
                                        $isThereAlreadyAclass = RoutineController::isThereAlreadyAclass($room->id, $slot->id,$dayId);
                                        while(!empty($isThereAlreadyAclass)){
                                            $dayId++;
                                            $isThereAlreadyAclass = RoutineController::isThereAlreadyAclass($room->id, $slot->id,$dayId);
                                        }    
                                    }
                                    $assign=array('courseId'=>$courseId,'teacherId'=>$teacherId,'sectionId'=>$sectionId,'roomId'=>$roomId,'dayId'=>$dayId,'slotId'=>$slotId);
                                    DB::table('routines')->insert($assign);
                                    $b++;
                                }
                                return redirect()->route("routines");
                            }
                            else{
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
                       // dd($day->day);
                        if($teacherDayoff->offday == $day->day){
                            break;
                        }
                        else if($classType->type == "Lab"){
                            $b=0;
                            while($b<2){
                                //$roomId=$room->id;
                                $roomType=$room->type;
                                if($roomType=="Theory"){
                                    foreach($rooms as $room){
                                        if($room->type=="Lab"){
                                            $roomId=$room->id;
                                        }
                                    }
                                }else{
                                    $roomId=$room->id;
                                }
                                $dayId=$day->id;
                                if($b==0){
                                    $slotId=$slot->id;
                                }if($b==1){
                                    $slotId++;;
                                    $isThereAlreadyAclass = RoutineController::isThereAlreadyAclass($room->id, $slotId,$day->id);
                                    while(!empty($isThereAlreadyAclass)){
                                        $slotId+=$slot->id+1;
                                        $isThereAlreadyAclass = RoutineController::isThereAlreadyAclass($room->id, $slotId,$day->id);
                                    }    
                                }
                                $assign=array('courseId'=>$courseId,'teacherId'=>$teacherId,'sectionId'=>$sectionId,'roomId'=>$roomId,'dayId'=>$dayId,'slotId'=>$slotId);
                                DB::table('routines')->insert($assign);
                                $b++;
                            }
                            return redirect()->route("routines");
                        }else if($classType->type == "Theory"){
                            $b=0;
                            while($b<2){
                                //$roomId=$room->id;
                                $roomType=$room->type;
                                $roomType=$room->type;
                                if($roomType=="Lab"){
                                    foreach($rooms as $room){
                                        if($room->type=="Theory"){
                                            $roomId=$room->id;
                                        }
                                    }
                                }else{
                                    $roomId=$room->id;
                                }
                                $slotId=$slot->id;
                                if($b==0){
                                    $dayId=$day->id;
                                }if($b==1){
                                    $dayId++;;
                                    $isThereAlreadyAclass = RoutineController::isThereAlreadyAclass($room->id, $slot->id,$dayId);
                                    while(!empty($isThereAlreadyAclass)){
                                        $dayId+=$day->id+1;
                                        $isThereAlreadyAclass = RoutineController::isThereAlreadyAclass($room->id, $slot->id,$dayId);
                                    }    
                                }
                                $assign=array('courseId'=>$courseId,'teacherId'=>$teacherId,'sectionId'=>$sectionId,'roomId'=>$roomId,'dayId'=>$dayId,'slotId'=>$slotId);
                                DB::table('routines')->insert($assign);
                                $b++;
                            }
                            return redirect()->route("routines");
                        }else{
                            $roomId=$room->id;
                            $dayId=$day->id;
                            $slotId=$slot->id;                    
                            $assign=array('courseId'=>$courseId,'teacherId'=>$teacherId,'sectionId'=>$sectionId,'roomId'=>$roomId,'dayId'=>$dayId,'slotId'=>$slotId);
                            DB::table('routines')->insert($assign);
                            $request->session()->flash('alert-success', 'Successfully assigned!');
                            return redirect()->route("routines");
                    }  }                     
                }
            }
        }


        // if (count($routines)>0){
        //         foreach($days as $day){
        //             foreach ($routines as $item) {
        //                 if ($item->sectionId == $sectionId && $item->dayId == $day->id) {
        //                     $sectionCount++;
        //                 }
        //                 if ($item->teacherId == $teacherId && $item->dayId == $day->id) {
        //                         $teacherCount++;
        //                 }
        //             }
        //             if($teacherCount==3 || $sectionCount==3){
        //                 break;
        //             }
        //             $sectionCount = 0;
        //             $teacherCount = 0;
        //         }
        //         if($teacherCount<3 && $sectionCount<3){
        //             foreach($days as $day){
        //                 foreach($slots as $slot){
        //                     foreach($rooms as $room){
        //                         foreach ($routines as $item) {
        //                             if($item->dayId == $day->id && $item->slotId == $slot->id && $item->roomId==$room->id && $item->sectionId==$sectionId){
        //                                 continue;
        //                             }else{
        //                                 $roomId=$room->id;
        //                                 $dayId=$day->id;
        //                                 //dd($slot->id);
        //                                 $slotId=$slot->id;
        //                                 $assign=array('courseId'=>$courseId,'teacherId'=>$teacherId,'sectionId'=>$sectionId,'roomId'=>$roomId,'dayId'=>$dayId,'slotId'=>$slotId);
        //                                 DB::table('routines')->insert($assign);
        //                                 $request->session()->flash('alert-success', 'Successfully assigned!');
        //                                 return redirect()->route("routines");
        //                             }
        //                         }
        //                     }
        //                 }
        //             }
        //         }
        //     }else{
        //         foreach($days as $day){
        //             foreach($slots as $slot){
        //                 foreach($rooms as $room){
        //                     $roomId=$room->id;
        //                     $dayId=$day->id;
        //                     $slotId=$slot->slotNo;                    
        //                     $assign=array('courseId'=>$courseId,'teacherId'=>$teacherId,'sectionId'=>$sectionId,'roomId'=>$roomId,'dayId'=>$dayId,'slotId'=>$slotId);
        //                     DB::table('routines')->insert($assign);
        //                     $request->session()->flash('alert-success', 'Successfully assigned!');
        //                     return redirect()->route("routines");
        //                 }                        
        //             }
        //         }
        //     }
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
