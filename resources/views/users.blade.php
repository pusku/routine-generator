@extends('layouts.app')
@section('body')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="well">
                <h4> Types list</h4>
                <table class="table-edit" >
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        
                        <th>Actions</th>
                    </tr>
                    @foreach($data as $user)
                        <tr>
                            <td> {{ $user->id }} </td>
                            <td> {{ $user->name }} </td>
                            <td> {{ $user->email }} </td>
                            
                            <td>
                                <a href="{{route('user_edit',$user->id)}}" class="btn btn-primary btn-mini"><i class="icon-edit icon-white"></i>E</a>
                                <a onclick="return confirm('Are you sure you want to delete this item?');" href="{{route('user_delete',$user->id)}}" class="btn btn-danger btn-mini"><i class="icon-remove icon-white"></i>X</a>
                            </td>
                        </tr>
                        @endforeach                                     
                </table>
            </div>
            <div class="text-center">
                
            </div>
        </div>
        <div class="col-md-4">
            <div class="well">
            @if(isset($userEditInfo)) 
                    <h4>Edit User</h4>
                @else
                    <h4>Create User </h4>
                @endif
                <form action="@if(isset($userEditInfo)) {{ route ('user_update',['id'=>$userEditInfo->id]) }} @else {{ route('user_store') }}@endif" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" class="form-control" id="name"  @if(isset($userEditInfo)) value='{{$userEditInfo->name}}' @endif>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" name="email" class="form-control" id="email"  @if(isset($userEditInfo)) value='{{$userEditInfo->email}}' @endif>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" class="form-control" id="password"  @if(isset($userEditInfo)) value='{{$userEditInfo->password}}' @endif>
                    </div>
                    <button type="submit" class="btn btn-default">
                        @if(isset($typeEditInfo)) 
                            Update User 
                        @else
                            Create User
                        @endif
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection