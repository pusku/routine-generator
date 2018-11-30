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
                <h4> Course List</h4>
                <div class="table-fix">
                    <table class="table-edit" >
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Credit</th>
                            <th>semester</th>
                            <th>actions</th>
                        </tr>
                        @foreach($data as $course)
                        <tr>
                            <td>{{$course->name}}</td>
                            <td>{{$course->type}}</td>
                            <td>{{$course->credit}}</td>
                            <td>{{$course->semester}}</td>
                            <td>
                                <a href="{{route('deleteCourse',['id'=>$course->id])}}" class="btn btn-danger">X</a>
                                <a href="{{route('editCourse',['id'=>$course->id])}}" class="btn btn-info">E</a>
                            </td>
                        </tr>
                        @endforeach                    
                    </table>
                </div>
            </div>
            <div class="text-center">
                
            </div>
            <div class="well">
                <h4> Course with Teacher</h4>
                <div class="table-fix">
                    <table class="table-edit" >
                        <tr>
                            <th>Course name</th>
                            <th>Semester</th>
                            <th>Section</th>
                            <th>Tteacher</th>
                            <th>Action </th>
                        </tr>
                      
                        <tr>
                            <th></th>
                            <td>
                              
                            </td>
                            <td>
                              
                            </td>
                            <td>
                              
                            </td>
                            <td>
                            <a href="" class="btn btn-primary btn-mini"><i class="icon-edit icon-white"></i>E</a>
                            
                            </td>
                        </tr>
                                           
                    </table>
                </div>
            </div>
            <div class="text-center">
                
            </div>
            </div>
        <div class="col-md-5">
            <div class="well">
                @if(isset($courseEditInfo)) 
                    <h4>Update Course</h4>
                @else
                    <h4>Add Course</h4>
                @endif
                <form action="@if(isset($courseEditInfo)) {{ route ('updateCourse',['id'=>$courseEditInfo->id]) }} @else {{ route ('addCourse') }} @endif" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" class="form-control" id="name" @if(isset($courseEditInfo)) value='{{$courseEditInfo->name}}' @endif >
                    </div>
                    <div class="form-group">
                        <label for="type">Type:</label>
                        <input type="text" name="type" class="form-control" id="type" @if(isset($courseEditInfo)) value='{{$courseEditInfo->type}}' @endif>
                    </div>
                    <div class="form-group">
                        <label for="credit">Credit:</label>
                        <input type="text" name="credit" class="form-control" id="credit" @if(isset($courseEditInfo)) value='{{$courseEditInfo->credit}}' @endif>
                    </div>
                    <div class="form-group">
                        <label for="semester">Semester:</label>
                        <input type="text" name="semester" class="form-control" id="semester" @if(isset($courseEditInfo)) value='{{$courseEditInfo->semester}}' @endif>
                    </div>
                    <button type="submit" class="btn btn-default">
                    @if(isset($courseEditInfo)) 
                        <h4>Update Course</h4>
                    @else
                        <h4>Add Course</h4>
                    @endif
                    </button>
                </form>
            </div>
            <div class="well">
                @if(isset($gmEditInfo)) 
                    <h4>Update teacher assigned to this course</h4>
                @else
                    <h4>Assign Teacher to this Course </h4>
                @endif
                <form action="" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                        @if(isset($gmEditInfo))
                            <input type="hidden" name="previousSelectedGroupId" value="{{$gmEditInfo->id}}">
                        @endif
                        <div class="form-group">
                            <label for="">Select the course:</label>
                            <select name="courseId" class="chosen-select-group form-control"  data-placeholder="Choose course..." >
                                @foreach ($data as $course)
                                    <option value="{{ $course->id }}" > {{ $course->name }} </option>
                                @endforeach 
                                @if(isset($gmEditInfo))
                                    <option value="{{ $gmEditInfo->id }}" selected> {{ $gmEditInfo->groupName }} </option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Add Section & Semester to the course:</label>
                            <select name="sectionId" class="chosen-select-member form-control"  data-placeholder="Choose Section...">
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}" > {{ $section->name }} {{ $section->semester }} </option>
                                @endforeach 
                                @if(isset($gmEditInfo))
                                    <option value="{{ $gmEditInfo->id }}" selected> {{ $gmEditInfo->groupName }} </option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Add Teacher to the course:</label>
                            <select name="teacherId" class="chosen-select-member form-control"  data-placeholder="Choose teacher...">
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" > {{ $teacher->name }}</option>
                                @endforeach 
                                @if(isset($ctEditInfo))
                                    <option value="{{ $gmEditInfo->id }}" selected> {{ $ctEditInfo->groupName }} </option>
                                @endif
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default">
                            Add Teacher
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection