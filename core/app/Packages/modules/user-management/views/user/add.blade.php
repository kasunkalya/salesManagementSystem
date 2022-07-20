@extends('layouts.master') @section('title','Add Menu')
@section('css')
<style type="text/css">
	.panel.panel-bordered {
	    border: 1px solid #ccc;
	}

	.btn-primary {
	    color: white;
	    background-color: #005C99;
	    border-color: #005C99;
	}

	.chosen-container{
		font-family: 'FontAwesome', 'Open Sans',sans-serif;
	}
</style>
@stop
@section('content')
<ol class="breadcrumb">
	<li>
    	<a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a>
  	</li>
  	<li>
    	<a href="javascript:;">User Management</a>
  	</li>
  	<li class="active">User Menu</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Add User</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post">
          		{!!Form::token()!!}
          			<div class="form-group">
	            		<label class="col-sm-2 control-label required">Name</label>
	            		<div class="col-sm-5">
	            			<input type="text" class="form-control @if($errors->has('first_name')) error @endif" name="first_name" placeholder="First Name" required value="{{Input::old('first_name')}}">
	            			@if($errors->has('first_name'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('first_name')}}</label>
	            			@endif
	            		</div>
	            		<div class="col-sm-5">
	            			<input type="text" class="form-control @if($errors->has('last_name')) error @endif" name="last_name" placeholder="Last Name" required value="{{Input::old('last_name')}}">
	            			@if($errors->has('last_name'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('last_name')}}</label>
	            			@endif
	            		</div>
	                </div>
	               
	                <div class="form-group">
	            		<label class="col-sm-2 control-label">Role</label>
	            		
	            		<div class="col-sm-10">
	            			@if($errors->has('roles[]'))
	            				{!! Form::select('roles[]',$roles, null,['class'=>'error', 'multiple','id'=>'roles','style'=>'width:100%;','required']) !!}
	            				<label id="label-error" class="error" for="label">{{$errors->first('roles[]')}}</label>
	            			@else
	            				{!! Form::select('roles[]',$roles, Input::old('roles[]'),['multiple','id'=>'roles','style'=>'width:100%;','required']) !!}
	            			@endif
	            		</div>
	                </div>
	          
	                <div class="form-group">
	            		<label class="col-sm-2 control-label required">E-mail</label>
	            		<div class="col-sm-8">
	            			<input type="text" class="form-control @if($errors->has('email')) error @endif" name="email" placeholder="Email" required value="{{Input::old('email')}}">
	            			@if($errors->has('email'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('email')}}</label>
	            			@endif
	            		</div>
	            		
	               </div>
	              
	               
	                <div class="form-group">
	            		<label class="col-sm-2 control-label required">User Name</label>
	            		<div class="col-sm-8">
	            			<input type="text" class="form-control @if($errors->has('username')) error @endif" name="username" placeholder="User Name" required value="{{Input::old('username')}}">
	            			@if($errors->has('username'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('username')}}</label>
	            			@endif
	            		</div>
	            		
	                </div>
	                <div class="form-group">
	            		<label class="col-sm-2 control-label required">Password</label>
	            		<div class="col-sm-8">
	            			<input type="password" class="form-control @if($errors->has('password')) error @endif" name="password" placeholder="Password" required value="{{Input::old('password')}}">
	            			@if($errors->has('password'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('password')}}</label>
	            			@endif
	            		</div>
	            		
	                </div>
	                <div class="form-group">
	            		<label class="col-sm-2 control-label required">Confirm Password</label>
	            		<div class="col-sm-8">
	            			<input type="password" class="form-control @if($errors->has('confirmed')) error @endif" name="password_confirmation" placeholder="Confirm Password" required value="{{Input::old('confirmed')}}">
	            			@if($errors->has('confirmed'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('confirmed')}}</label>
	            			@endif
	            		</div>
	            		
	                </div>
	                <div class="pull-right">
	                	<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
	                </div>


		          	
            	</form>
          	</div>
        </div>
	</div>
</div>
@stop
@section('js')
<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.form-validation').validate();
		$('#permissions').multiSelect();
	});
	
	
</script>
@stop
