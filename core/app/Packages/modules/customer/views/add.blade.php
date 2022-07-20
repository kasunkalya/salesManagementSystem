@extends('layouts.master') @section('title','Add Customer')
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
    	<a href="{{{url('customer/list')}}}">Customer</a>
  	</li>
  	<li class="active">Add Customer</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Add Customer</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
          		{!!Form::token()!!}
					
                                   
                    <div class="form-group">
                            <label class="col-sm-2 control-label required">Customer Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @if($errors->has('customerName')) error @endif" id="customerName" name="customerName" placeholder="Customer Name" required value="{{Input::old('customerName')}}">
                                    @if($errors->has('customerName'))
                                        <label id="label-error" class="error" for="code">{{$errors->first('customerName')}}</label>
                                    @endif
                            </div>
                    </div>
                        
					<div class="form-group">
                            <label class="col-sm-2 control-label required">Customer Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control @if($errors->has('customerEmail')) error @endif" id="customerEmail" name="customerEmail" placeholder="Customer Email" required value="{{Input::old('customerEmail')}}">
                                    @if($errors->has('customerEmail'))
                                        <label id="label-error" class="error" for="code">{{$errors->first('customerEmail')}}</label>
                                    @endif
                            </div>
                    </div>
					
					<div class="form-group">
                            <label class="col-sm-2 control-label required">Customer Mobile</label>
                            <div class="col-sm-10">
                                <input type="tel"  class="form-control @if($errors->has('customerMobile')) error @endif" id="customerMobile" name="customerMobile" placeholder="Customer Mobile" required value="{{Input::old('customerMobile')}}">
                                    @if($errors->has('customerMobile'))
                                        <label id="label-error" class="error" for="code">{{$errors->first('customerMobile')}}</label>
                                    @endif
                            </div>
                    </div>
                                    
	                <div class="pull-right">
                            <button type="submit" class="btn btn-primary" id="add"><i class="fa fa-floppy-o"></i> Save</button>
	                </div>
            	</form>
          	</div>
        </div>
	</div>
</div>
@stop
@section('js')
<script src="{{asset('assets/support/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
        $('#add').click(function(e){               
            var mailformat = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            var contact=/^\d{10}$/;
            var customerName =document.getElementById("customerName").value;                            
            if(customerName ==''){
                sweetAlert(' Error','Please enter customer name.',3);
                return false;
            }  

			var customerEmail =document.getElementById("customerEmail").value;                            
            if(customerEmail ==''){
                sweetAlert(' Error','Please enter customer email.',3);
                return false;
            } else if(!customerEmail.match(mailformat)){
				sweetAlert(' Error','Invalid email address.',3);
                return false;
			}

			var customerMobile =document.getElementById("customerMobile").value;                            
            if(customerMobile ==''){
                sweetAlert(' Error','Please enter customer mobile.',3);
                return false;
            } else if(!customerMobile.match(contact)){
				sweetAlert(' Error','Invalid customer mobile.',3);
                return false;
			}         
            
        });
</script>
@stop
