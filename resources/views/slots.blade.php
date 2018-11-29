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
                <h4>Time Slots</h4>
                <div class="table-fix">
                    <table class="table-edit" >
                        <tr>
                            <th>Slot No</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Type</th>
                            <th>actions</th>
                        </tr>
                        @foreach($data as $slot)
                        <tr>
                            <td>{{$slot->slotNo}}</td>
                            <td>{{$slot->startTime}}</td>
                            <td>{{$slot->endTime}}</td>
                            <td>{{$slot->type}}</td>
                            <td>
                                <a href="{{route('deleteSlot',['id'=>$slot->id])}}" class="btn btn-danger">X</a>
                                <a href="{{route('editSlot',['id'=>$slot->id])}}" class="btn btn-info">E</a>
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
                @if(isset($slotEditInfo)) 
                    <h4>Add Time Slot</h4>
                @else
                    <h4>Add Time Slot</h4>
                @endif
                <form action="@if(isset($slotEditInfo)) {{ route ('updateSlot',['id'=>$slotEditInfo->id]) }} @else {{ route ('addSlot') }} @endif" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="slotNo">Slot No:</label>
                        <input type="text" name="slotNo" class="form-control" id="slotNo" @if(isset($slotEditInfo)) value='{{$slotEditInfo->slotNo}}' @endif >
                    </div>
                    <div class="form-group">
                        <label for="startTime">Start Time:</label>
                        <input type="text" name="startTime" class="form-control" id="startTime" @if(isset($slotEditInfo)) value='{{$slotEditInfo->startTime}}' @endif>
                    </div>
                    <div class="form-group">
                        <label for="endTime">End Time:</label>
                        <input type="text" name="endTime" class="form-control" id="endTime" @if(isset($slotEditInfo)) value='{{$slotEditInfo->endTime}}' @endif>
                    </div>
                    <div class="form-group">
                        <label for="type">Type:</label>
                        <input type="text" name="type" class="form-control" id="type" @if(isset($slotEditInfo)) value='{{$slotEditInfo->type}}' @endif>
                    </div>
                    <button type="submit" class="btn btn-default">
                    @if(isset($slotEditInfo)) 
                        <h4>Add Time Slot</h4>
                    @else
                        <h4>Add Time Slot</h4>
                    @endif
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection