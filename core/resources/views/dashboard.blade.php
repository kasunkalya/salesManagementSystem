@extends('layouts.master') @section('title','Dashboard')
@section('current_title','Dashboard')
@section('content')
<style type="text/css">
  .bg-black {
    color: #616161;
    background-color: #556B8D;
}


.bg-red {
    color: #616161;
    background-color: #EFA131;
}

.bg-blue {
    color: #616161;
    background-color: #55822A;
}

.widget .widget-title {
    display: block;
    font-size: 25px;
    line-height: 1;
    color: #fff;
    font-family:'Open Sans',sans-serif;
}

.widget .widget-subtitle {
    font-size: 12px;
    color: #fff;
}

.bg-white3 {
    color: #EFA131;
    background-color: #fff;
}


.bg-white1 {
    color: #556B8D;
    background-color: #fff;
}

.bg-white2 {
    color: #55822A;
    background-color: #fff;
}

.widget .widget-icon {
    display: inline-block;
    vertical-align: middle;
    width: 40px;
    height: 40px;
    border-radius: 20px;
    text-align: center;
    font-size: 25px;
    line-height: 40px;
}

small, .small {
    font-size: 15px;
}
dt,.bold {
    font-weight: 700;
}

.bg-white {
    color: #616161;
    background-color: white;
    border: 1px solid #ccc;
}

.bg-lightblue {
    color: white;
    background-color: #4CC3D9;
}

.bg-brown {
    color: white;
    background-color: #D96557;
}

.bg-success {
    color: white;
    background-color: #FFC65D;
}

.bg-primary {
    color: white;
    background-color: #34495e;
}

.text-success {
    color: #556B8D;
}

.main-panel > .header .navbar-nav .dropdown-menu {
    margin-top: 2px;
    padding: 0;
    border-color: rgba(0, 0, 0, 0.1);
    border-top: 0;
    background-color: white;
    -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    -moz-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    -webkit-border-radius: 0;
    -moz-border-radius: 0;
    border-radius: 0;
    width: 100%;
}
</style>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    
    </script>
   

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-bordered">
            <div class="panel-heading border">
                <strong> View Sales </strong>
            </div> 
            @if (Sentinel::getUser(1)->roles[0]->pivot->role_id === 1)
            <div class="panel-body">
                <form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
                    {!!Form::token()!!}
               
                
                                       <div class="form-group">
	            		<label class="col-sm-2 control-label">Product</label>
	            		<div class="col-sm-10">
	            		
	            			@if($errors->has('product'))
	            				{!! Form::select('product',$product, Input::old('product'),['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'product']) !!}
	            				<label id="customer-error" class="error" for="product">{{$errors->first('product')}}</label>
	            			@else
	            				{!! Form::select('product',$product, Input::old('product'),['class'=>'chosen ','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'product']) !!}
	            			@endif
	            			
	            		</div>
	                </div>
                    
                        <div class="form-group">
	            		<label class="col-sm-2 control-label">Year</label>
	            		<div class="col-sm-10">
	            		
	            			@if($errors->has('year'))
	            				{!! Form::select('year',$year, Input::old('year'),['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After' ,'id'=>'year']) !!}
	            				<label id="customer-error" class="error" for="year">{{$errors->first('year')}}</label>
	            			@else
	            				{!! Form::select('year',$year, Input::old('year'),['class'=>'chosen ','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'year']) !!}
	            			@endif
	            			
	            		</div>
	                </div>

                <button id="search" type="button" class="btn btn-primary"><i class="fa fa-search"></i> Search</button> 
                </form>
            </div>
        </div>
        @endif
        
        <div id="curve_chart" style="width: 100%; height: 500px;"></div>
        
    </div>
</div>





@stop
@section('js')
  <!-- page level scripts -->
  <script src="{{asset('assets/support/vendor/d3/d3.min.js')}}"></script>
  <script src="{{asset('assets/support/vendor/rickshaw/rickshaw.min.js')}}"></script>
  <script src="{{asset('assets/support/vendor/flot/jquery.flot.js')}}"></script>
  <script src="{{asset('assets/support/vendor/flot/jquery.flot.resize.js')}}"></script>
  <script src="{{asset('assets/support/vendor/flot/jquery.flot.categories.js')}}"></script>
  <script src="{{asset('assets/support/vendor/flot/jquery.flot.pie.js')}}"></script>
  <!-- /page level scripts -->

  <!-- initialize page scripts -->
  <script src="{{asset('assets/support/scripts/pages/dashboard.js')}}"></script>
  <!-- /initialize page scripts -->
  
  <script src="{{asset('assets/support/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
	var id = 0;
	var table = '';
	$(document).ready(function(){
            var curentYear={{ date('Y')}};
                    $.ajax({
                            url: "{{url('json/orderlist/')}}/"+curentYear+"/all",
                                    type:"GET",
                                    
                                    async: true,
                                    cache: false,
                                    success:function(data){

                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
                    
                     var statesArray = [ ['Month', 'Sales' ]];          
                        for (i = 0; i < data.length; i++) {
                            var stateitem = [data[i][1], data[i][2]];
                            statesArray.push(stateitem);
                        }

                    function drawChart() {                     
                       var data = google.visualization.arrayToDataTable(statesArray);
                      var options = {
                        title: 'Sales in '+curentYear+' for All Products' ,
                        curveType: 'function',
                        legend: { position: 'bottom' }
                      };

                      var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

                      chart.draw(data, options);
                    }
                    
                                    
                                    },
                                    error:function(jqXHR, textStatus, errorThrown){
                                    alert('Something went wrong.\nPlease check the internet connection.\nIf problem continue contact administrator.')

                                    }
                            });
            
                    
                    
	});


        $('#search').click(function(e){ loadTable()});
        
        function loadTable(){
          
            var year=document.getElementById("year").value;
            var product=document.getElementById("product").value;
            
            var el = document.getElementById('product');
            var text = el.options[el.selectedIndex].innerHTML;
          
             $.ajax({
                    url: "{{url('json/orderlist/')}}/"+year+"/"+product,
                                    type:"GET",
                                    
                                    async: true,
                                    cache: false,
                                    success:function(data){

                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
                    
                     var statesArray = [ ['Month', 'Sales' ]];          
                        for (i = 0; i < data.length; i++) {
                            var stateitem = [data[i][1], data[i][2]];
                            statesArray.push(stateitem);
                        }

                    function drawChart() {                     
                       var data = google.visualization.arrayToDataTable(statesArray);
                      var options = {
                         title: 'Sales in '+year+' for '+text,
                        curveType: 'function',
                        legend: { position: 'bottom' }
                      };

                      var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

                      chart.draw(data, options);
                    }
                    
                                    
                                    },
                                    error:function(jqXHR, textStatus, errorThrown){
                                    alert('Something went wrong.\nPlease check the internet connection.\nIf problem continue contact administrator.')

                                    }
                            });
        }
</script>
@stop
