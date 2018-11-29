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
        </div>
    </div>
    </div>
    </div>
@endsection