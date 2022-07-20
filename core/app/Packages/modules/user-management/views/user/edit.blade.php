@extends('layouts.master') @section('title','Edit Menu')
@section('css')
<style type="text/css">
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
  	<li>
    	<a href="{{{url('menu/list')}}}">User List</a>
  	</li>
  	<li class="active">Edit User</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Edit Menu</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post">
          		{!!Form::token()!!}
          			<div class="form-group">
	            		<label class="col-sm-2 control-label required">Name</label>
	            		<div class="col-sm-5">
	            			<input type="text" class="form-control @if($errors->has('first_name')) error @endif" name="first_name" placeholder="First Name" required value="{{$curUser->first_name}}">
	            			@if($errors->has('first_name'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('first_name')}}</label>
	            			@endif
	            		</div>
	            		<div class="col-sm-5">
	            			<input type="text" class="form-control @if($errors->has('last_name')) error @endif" name="last_name" placeholder="Last Name" required value="{{$curUser->last_name}}">
	            			@if($errors->has('last_name'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('last_name')}}</label>
	            			@endif
	            		</div>
	                </div>
	                <div class="form-group">
	            		<label class="col-sm-2 control-label required">E-mail</label>
	            		<div class="col-sm-8">
	            			<input type="text" class="form-control @if($errors->has('email')) error @endif" name="email" placeholder="Email" required value="{{$curUser->email}}">
	            			@if($errors->has('email'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('email')}}</label>
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
	            				{!! Form::select('roles[]',$roles,$srole,['multiple','id'=>'roles','style'=>'width:100%;','required']) !!}
	            			@endif
	            		</div>
	                </div>
	                <div class="form-group">
	            		<label class="col-sm-2 control-label required">User Name</label>
	            		<div class="col-sm-8">
	            			<input type="text" class="form-control @if($errors->has('username')) error @endif" name="username" placeholder="User Name" required value="{{$curUser->username}}">
	            			@if($errors->has('username'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('username')}}</label>
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
