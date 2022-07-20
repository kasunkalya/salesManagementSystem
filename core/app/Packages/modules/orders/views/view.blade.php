@extends('layouts.master') @section('title','View Order')
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
    <li class="active">View Order</li>
</ol>
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-bordered">
            <div class="panel-heading border">
                <strong> View Order </strong>
            </div>
            <div class="panel-body">
                <form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
                    {!!Form::token()!!}

                    <div class="form-group">
                        <label class="col-sm-2 control-label required">Order Date</label>
                        <div class="col-sm-10">                                                												
                            <input type="text" class="form-control @if($errors->has('orderDate')) error @endif" name="orderDate" id="orderDate" placeholder="Order Date" value="{{$orders[0]->order_Date}}" >
                            @if($errors->has('orderDate'))
                            <label id="label-error" class="error" for="label">{{$errors->first('orderDate')}}</label>
                            @endif														

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Customer</label>
                        <div class="col-sm-10">

                            @if($errors->has('customer'))
                            {!! Form::select('customer',$customer, $orders[0]->customer,['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After']) !!}
                            <label id="customer-error" class="error" for="customer">{{$errors->first('customer')}}</label>
                            @else
                            {!! Form::select('customer',$customer, $orders[0]->customer,['class'=>'chosen ','style'=>'width:100%;','required','data-placeholder'=>'Set After']) !!}
                            @endif

                        </div>
                    </div>

                   
                    <table  class="table dynatable table-bordered bordered table-striped table-condensed datatable" >
                        <thead>
                            <tr>
                                <th class="text-center">Product</th>           
                                <th class="text-center">Unit Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Total Price</th>
                            </tr>
                        </thead>
                        <tbody id="p_scents" >

                            @for ($i = 0; $i < sizeof($orderList); $i++)
                            <tr>
                                <td>                                   
                                        @for ($x =0; $x < sizeof($product); $x++) 
                                            @if ($orderList[$i]->products == $product[$x]->id)
                                            <input disabled type="text" value="{{$product[$x]->product_Name}}" />       
                                            @endif
                                        @endfor                                    
                                </td>           
                                <td><input type="text" disabled name="unitprice[]" value="{{$orderList[$i]->unitPrice}}" id="unitprice{{$orderList[$i]->id}}"/></td>
                                <td><input type="text" disabled name="quantity[]" id="quantity{{$orderList[$i]->id}}" value="{{$orderList[$i]->itemCount}}" onchange="getTotalCurentPrice({{$orderList[$i]->id}})"/></td>
                                <td><input type="text" disabled name="totalPrice[]" value="{{ $orderList[$i]->unitPrice * $orderList[$i]->itemCount}}" id="totalPrice{{$orderList[$i]->id}}"/></td>
                            </tr>
                            @endfor



                        </tbody>
                    </table>  
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
                            scntDiv.append('<tr><td><select class="chosen" style=" width: 100%;" name="product[]" id="product' + i + '" onchange="getunitPrice(' + i + ')"><?php
echo '<option value="">Select Product</option>';
for ($x = 0; $x < sizeof($product); $x++) {
    echo '<option value="' . $product[$x]->id . '">' . $product[$x]->product_Name . '</option>';
}
?></select></td><td><input type="text" name="unitprice[]" value="0" id="unitprice' + i + '"/></td><td><input type="text" name="quantity[]" id="quantity' + i + '" value="0" onchange="getTotalPrice(' + i + ')"/></td><td><input type="text" name="totalPrice[]" value="0" id="totalPrice' + i + '"/></td><td><a href="#" id="remScnt" class="red type-delete"><i class="fa fa-trash-o"></i></a></td></tr>');
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
                            function deleteoderItem(i){

                            sweetAlertConfirm('Delete Order', 'Are you sure?', 2, deleteFunc);
                            function deleteFunc(){
                            ajaxRequest('{{url('orders / deleteitem')}}', { 'id' : i  }, 'post', handleData);
                            }

                            function handleData(data){
                            if (data.status == 'success'){
                            sweetAlert('Delete Success', 'Record Deleted Successfully!', 0);
                            //table.ajax.reload();
                            } else if (data.status == 'invalid_id'){
                            sweetAlert('Delete Error', 'Permission Id doesn\'t exists.', 3);
                            } else{
                            sweetAlert('Error Occured', 'Please try again!', 3);
                            }
                            }

                            }


                            function getunitPrice(i){
                            var dropdown = $("#product" + i).val();
                            $.ajax({
                            url: "{{url('product/details')}}",
                                    type:"POST",
                                    data:{id:dropdown},
                                    async: true,
                                    cache: false,
                                    success:function(objects){
                                    document.getElementById("unitprice" + i).value = objects[0]['unit_Price'];
                                    },
                                    error:function(jqXHR, textStatus, errorThrown){
                                    alert('Something went wrong.\nPlease check the internet connection.\nIf problem continue contact administrator.')

                                    }
                            });
                            }

                            function getTotalPrice(i){
                            var unitprice = $("#unitprice" + i).val();
                            var quantity = $("#quantity" + i).val();
                            document.getElementById("totalPrice" + i).value = unitprice * quantity;
                            }
                            function getTotalCurentPrice(i){
                            var unitprice = $("#unitprice" + i).val();
                            var quantity = $("#quantity" + i).val();
                            document.getElementById("totalPrice" + i).value = unitprice * quantity;
                            }

                            $(document).ready(function(){

                            $("#orderDate").datepicker({
                            format: "yyyy-mm-dd",
                            });
                            });
</script>
@stop
