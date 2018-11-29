@extends('layouts.app') 
@section('body')
<div class="container">
<h1>Generated Routine</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>Day\Time</td>
            <td>Name</td>
            <td>Email</td>
            <td>Nerd Level</td>
            <td>Actions</td>
        </tr>
    </thead>
    <tbody>
   
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
            <a href="" class="btn btn-primary btn-mini"><i class="icon-edit icon-white"></i>E  </a>
            <a onclick="return confirm('Are you sure you want to delete this item?');" href="" class="btn btn-danger btn-mini"><i class="icon-remove icon-white"></i>X</a>
            </td>
        </tr>
    </tbody>
</table>
</div>
@endsection