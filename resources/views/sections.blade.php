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
                <h4> Section List</h4>
                <div class="table-fix">
                    <table class="table-edit" >
                        <tr>
                            <th>Name</th>
                            <th>Semester</th>
                            <th>actions</th>
                        </tr>
                        @foreach($data as $section)
                        <tr>
                            <td>{{$section->name}}</td>
                            <td>{{$section->semester}}</td>
                            <td>
                            <a href="{{route('deleteSection',['id'=>$section->id])}}" class="btn btn-danger">X</a>
                            <a href="{{route('editSection',['id'=>$section->id])}}" class="btn btn-info">E</a>
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
                @if(isset($sectionEditInfo)) 
                    <h4>Update Section </h4>
                @else
                    <h4>Add Section </h4>
                @endif
                <form action="@if(isset($sectionEditInfo)) {{ route ('updateSection',['id'=>$sectionEditInfo->id]) }} @else {{ route ('addSection') }} @endif" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" class="form-control" id="name" @if(isset($sectionEditInfo)) value='{{$sectionEditInfo->name}}' @endif >
                    </div>
                    <div class="form-group">
                        <label for="type">Semester:</label>
                        <input type="text" name="semester" class="form-control" id="semester" @if(isset($sectionEditInfo)) value='{{$sectionEditInfo->semester}}' @endif>
                    </div>
                    <button type="submit" class="btn btn-default">
                        @if(isset($sectionEditInfo)) 
                            <h4>Update Section </h4>
                        @else
                            <h4>Add Section </h4>
                        @endif
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