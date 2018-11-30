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
    <thead>
        <tr>
            <td>Actions</td>
            <td>Day\Time</td>
            @foreach($slots as $slot)
                <td>{{$slot->startTime}}-{{$slot->endTime}}</td>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($days as $day)
            <tr>
                <td>
                <a href="" class="btn btn-primary btn-mini"><i class="icon-edit icon-white"></i>E</a>
                <a onclick="return confirm('Are you sure you want to delete this item?');" href="" class="btn btn-danger btn-mini"><i class="icon-remove icon-white"></i>X</a>
                </td>
                <td>{{$day->day}}</td>
            </tr>
        @endforeach
        
    </tbody>
</table>
</div>
@endsection