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
                <h4> Teacher List</h4>
                <div class="table-fix">
                    <table class="table-edit" >
                        <tr>
                            <th>Teacher ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Initial</th>
                            <th>Off Day</th>
                            <th>actions</th>
                        </tr>
                        @foreach($data as $teacher)
                        <tr>
                            <td>{{$teacher->teacherId}}</td>
                            <td>{{$teacher->name}}</td>
                            <td>{{$teacher->email}}</td>
                            <td>{{$teacher->phone}}</td>
                            <td>{{$teacher->initial}}</td>
                            <td>{{$teacher->offday}}</td>
                            <td>
                                <a href="{{route('deleteTeacher',['id'=>$teacher->id])}}" class="btn btn-danger">X</a>
                                <a href="{{route('editTeacher',['id'=>$teacher->id])}}" class="btn btn-info">E</a>
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
                @if(isset($roomEditInfo)) 
                    <h4>Update Teacher</h4>
                @else
                    <h4>Add Teacher</h4>
                @endif
                <form action="@if(isset($teacherEditInfo)) {{ route ('updateTeacher',['id'=>$teacherEditInfo->id]) }} @else {{ route ('addTeacher') }}@endif" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="teacherId">Teacher ID:</label>
                        <input type="text" name="teacherId" class="form-control" id="teacherId" @if(isset($teacherEditInfo)) value='{{$teacherEditInfo->teacherId}}' @endif placeholder = "Nullable">
                    </div>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" class="form-control" id="name" @if(isset($teacherEditInfo)) value='{{$teacherEditInfo->name}}' @endif>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" name="email" class="form-control" id="email" @if(isset($teacherEditInfo)) value='{{$teacherEditInfo->email}}' @endif placeholder = "Nullable">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" name="phone" class="form-control" id="phone" @if(isset($teacherEditInfo)) value='{{$teacherEditInfo->phone}}' @endif placeholder = "Nullable">
                    </div>
                    <div class="form-group">
                        <label for="initial">Initial:</label>
                        <input type="text" name="initial" class="form-control" id="initial" @if(isset($teacherEditInfo)) value='{{$teacherEditInfo->initial}}' @endif>
                    </div>
                   
                    <div class="form-group">
                            <label for="offday">Off Day:</label>
                            <select name="offday" class="chosen-select-member form-control"  data-placeholder="Choose offday...">
                            @foreach ($days as $day)
                                    <option value="{{ $day->day }}" > {{ $day->day }}</option>
                                @endforeach 
                                <option value="None" > None</option>
                            </select>
                            </div>
                    <button type="submit" class="btn btn-default">
                        @if(isset($teacherEditInfo)) 
                            <h4>Update Teacher</h4>
                        @else
                            <h4>Add Teacher</h4>
                        @endif
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection