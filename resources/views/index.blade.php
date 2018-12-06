@extends('layouts.app') 
@section('body')
<div class="container">
<h1>Generated Routine</h1>
            <select name="" class="chosen-select-member form-control"  data-placeholder="Choose group names...">
                <option value="" selected>1A</option>
            </select>
<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<table class="table table-striped table-bordered">
    @foreach($days as $day)
    <tr>
        <th style="text-align:center; color:red;" colspan="6">{{$day->day}}</th>
    </tr>
    @foreach($slots as $slot)
    <tr>
      
        <th style="text-align:center; color:blue" colspan="4">{{$slot->startTime}}-{{$slot->endTime}}</th>
    </tr>
    <tr>
    <th style="color:green">Room</th>
    <th style="color:green">Course</th>
    <th style="color:green">Teacher</th>
    <th style="color:green">Section</th>
  </tr>
  @foreach($rooms as $room)
  @foreach($routines as $routine)
  @if($day->id==$routine->dayId && $slot->id==$routine->slotId && $room->id==$routine->roomId)
  <tr>
    <td>{{$room->name}}</td>
    <td>{{$routine->course->name}}</td>
    <td>{{$routine->teacher->name}}</td>
    <td>{{$routine->section->name}}</td>
    </tr>
  @endif
    @endforeach
@endforeach
  @endforeach
    @endforeach
</table>
</div>
@endsection