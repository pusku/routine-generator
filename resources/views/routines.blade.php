@extends('layouts.app') 
@section('stylesheet')
    <link rel="stylesheet" href="{{asset('css/chosenCss/prism.css')}}">
    <link rel="stylesheet" href="{{asset('css/chosenCss/chosen.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
@endsection

@section('body')
<div class="container">
    <div class="row">
        <div class="col-md-7">
            <div class="well">
                <h4> Routine</h4>
                <div class="table-fix">
                    <table class="table-edit" >
                        <tr>
                            <th>Course</th>
                            <th>Section & Semester</th>
                            <th>Teacher</th>
                            <th>Room</th>
                            <th>Day</th>
                            <th>Slot</th>
                            <th>Action </th>
                        </tr>
                        @foreach($routines as $routine)
                        <tr>
                            <td>{{$routine->course->name}}</td>
                            <td>{{$routine->section->name}}</td>
                            <td>{{$routine->teacher->name}}</td>
                            <td>{{$routine->room->name}}</td>
                            <td>{{$routine->day->day}}</td>
                            <td>{{$routine->slot->slotNo}}</td>
                            <td>
                            <a href="{{route('deleteRoutine',['id'=>$routine->id])}}" class="btn btn-danger">X</a>
                            
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="text-center"></div>
        </div>
        <div class="col-md-5">
            <div class="well">
                    <h4>Assign Teacher Course to a Section </h4>
                <form action="{{ route ('addRoutine') }}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                        <div class="form-group">
                            <label for="">Select the course:</label>
                            <select name="courseId" class="chosen-select-group form-control"  data-placeholder="Choose course..." >
                            @foreach ($courses as $course)
                                    <option value="{{ $course->id }}" > {{ $course->name }} </option>
                                @endforeach 
                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Add Section & Semester to the course:</label>
                            <select name="sectionId" class="chosen-select-member form-control"  data-placeholder="Choose Section...">
                            @foreach ($sections as $section)
                                    <option value="{{ $section->id }}" > {{ $section->name }} </option>
                                @endforeach 
                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Add Teacher to the course:</label>
                            <select name="teacherId" class="chosen-select-member form-control"  data-placeholder="Choose teacher...">
                            @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" > {{ $teacher->name }}</option>
                                @endforeach 
                                
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default">
                            <h4>Assign Teacher & course to this Section</h4>
                        </button>
                    </form>
                </div>
        </div>
    </div>
    </div>
    </div>
@endsection
@section('javascript')
    <script src="{{asset('js/chosenJs/chosen.jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/chosenJs/prism.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('js/jquery-ui.min.js')}}" type="text/javascript" charset="utf-8"></script>
    
    <script>
        $(".chosen-select-type").chosen({
            no_results_text: "Oops, nothing found!",
            width: "100%"
        });

        $(".chosen-select-group").chosen({
            no_results_text: "Oops, nothing found!",
            width: "100%"
        });

        $(".chosen-select-member").chosen({
            no_results_text: "Oops, nothing found!",
            width: "100%"
        });

        
        $( "#startdate" ).datepicker({
            inline: true,
            changeYear: true
        });
        
        $( "#finishdate" ).datepicker({
            inline: true,
            changeYear: true
        });
    </script>
@endsection