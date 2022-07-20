@extends('layouts.master') @section('title','Edit Product')
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
    	<a href="{{{url('product/list')}}}">Product</a>
  	</li>
  	<li class="active">Edit Product</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Edit Product</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
          		{!!Form::token()!!}                     
                    <div class="form-group">
                            <label class="col-sm-2 control-label required">Product Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @if($errors->has('productName')) error @endif" id="productName" name="productName" placeholder="Product Name" required value="{{ $product[0]->product_Name}}">
                                    @if($errors->has('productName'))
                                        <label id="label-error" class="error" for="code">{{$errors->first('productName')}}</label>
                                    @endif
                            </div>
                    </div>       
					
					<div class="form-group">
                            <label class="col-sm-2 control-label required">Unit Price</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @if($errors->has('unitPrice')) error @endif" id="unitPrice" name="unitPrice" placeholder="Unit Price" required value="{{ $product[0]->unit_Price}}">
                                    @if($errors->has('unitPrice'))
                                        <label id="label-error" class="error" for="code">{{$errors->first('unitPrice')}}</label>
                                    @endif
                            </div>
                    </div>
                        
	                <div class="pull-right">
                            <button type="submit" id="update" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
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
        $('#update').click(function(e){               
            var productName =document.getElementById("productName").value;                            
            if(productName ==''){
                sweetAlert(' Error','Please enter product name.',3);
                return false;
            }  
            
        });
</script>
@stop
