@extends('layouts.master') @section('title','Add Order')
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
    	<a href="{{{url('orders/list')}}}">Order</a>
  	</li>
  	<li class="active">Order Add</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Order Add</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
          		{!!Form::token()!!}
				  <div class="form-group">
                        <label class="col-sm-2 control-label required">Order Date</label>
                        <div class="col-sm-10">                                                												
                                <input type="text" class="form-control @if($errors->has('orderDate')) error @endif" name="orderDate" id="orderDate" placeholder="Order Date" value="{{date('Y-m-d')}}" >
                                    @if($errors->has('orderDate'))
                                        <label id="label-error" class="error" for="label">{{$errors->first('orderDate')}}</label>
                                    @endif														

                        </div>
                    </div>
                 
			<div class="form-group">
	            		<label class="col-sm-2 control-label">Customer</label>
	            		<div class="col-sm-10">
	            		
	            			@if($errors->has('customer'))
	            				{!! Form::select('customer',$customer, Input::old('customer'),['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After']) !!}
	            				<label id="customer-error" class="error" for="customer">{{$errors->first('customer')}}</label>
	            			@else
	            				{!! Form::select('customer',$customer, Input::old('customer'),['class'=>'chosen ','style'=>'width:100%;','required','data-placeholder'=>'Set After']) !!}
	            			@endif
	            			
	            		</div>
	                </div>
                        
<h2>
    <a href="#" id="addScnt"><button type="submit" class="btn btn-primary" id="add"><i class="fa fa-shopping-cart"></i>  Add New Product</button></a>
</h2>
<table class="table dynatable table-bordered bordered table-striped table-condensed datatable">
    <thead>
        <tr>
            <th class="text-center">Product</th>           
            <th class="text-center">Unit Price</th>
            <th class="text-center">Quantity</th>
            <th class="text-center">Total Price</th>
            <th class="text-center"></th>
        </tr>
    </thead>
    <tbody id="p_scents">
        
    </tbody>
</table>                     
                                    
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
        // $('#add').click(function(e){               
                       
        //     var productName =document.getElementById("productName").value;                            
        //     if(productName ==''){
        //         sweetAlert(' Error','Please enter product name.',3);
        //         return false;
        //     }  
            
           
            
        // });


var scntDiv = $('#p_scents');
var i = $('#p_scents tr').size() + 1;

$('#addScnt').click(function() {
    scntDiv.append('<tr><td><select class="chosen" style=" width: 100%;" name="product[]" id="product'+i+'" onchange="getunitPrice('+i+')"><?php 
	echo '<option value="">Select Product</option>';
	for ($x =0; $x < sizeof($product); $x++) {
       echo '<option value="'.$product[$x]->id.'">'.$product[$x]->product_Name.'</option>';
    }  
  ?></select></td><td><input type="text" name="unitprice[]" value="0" id="unitprice'+i+'"/></td><td><input type="text" name="quantity[]" id="quantity'+i+'" value="0" onchange="getTotalPrice('+i+')"/></td><td><input type="text" name="totalPrice[]" value="0" id="totalPrice'+i+'"/></td><td><a href="#" id="remScnt" class="red type-delete"><i class="fa fa-trash-o"></i></a></td></tr>');   
    i++;
    return false;
});

//Remove button
$(document).on('click', '#remScnt', function() {
    if (i > 2) {
        $(this).closest('tr').remove();
        i--;
    }
    return false;
});



function getunitPrice(i){
	var dropdown=$("#product"+i).val();
	$.ajax({ 
                    url: "{{url('product/details')}}",
                    type:"POST",
					data:{id:dropdown},
                    async: true,
                    cache: false,
                    success:function(objects){
						document.getElementById("unitprice"+i).value = objects[0]['unit_Price'];                       
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        alert('Something went wrong.\nPlease check the internet connection.\nIf problem continue contact administrator.')
                        
                    }
                });
	}

	function getTotalPrice(i){
	var unitprice=$("#unitprice"+i).val();
	var quantity=$("#quantity"+i).val();

	document.getElementById("totalPrice"+i).value = unitprice * quantity;  

	}


	$(document).ready(function(){
             
                $( "#orderDate" ).datepicker({
                  format: "yyyy-mm-dd",  
                });
	});
</script>
@stop
