@extends('layouts.user')

@section('custom_css')
	<link href="{{asset('assets/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('content')

	<!-- BEGIN PAGE BAR -->
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="{{ URL::to('adminUser') }}">Dashboard</a>
				<i class="fa fa-circle"></i>
			</li>
			<li>
				<a href="#">Refferal System</a>
				<i class="fa fa-circle"></i>
			</li>
		</ul>
	</div>
	<!-- END PAGE BAR -->
	<!-- BEGIN PAGE TITLE-->

	<div class="content">
		<div class="col-md-6">
			<h3 class="page-title"> Refferal System </h3>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="portlet-body form">
					<div class="form-horizontal">
						<div class="form-body">
							<div class="row">
								<div class="col-md-12">

									<div class="form-group">
										<label class="col-md-3 control-label">  Name <span class="red"></span> : </label>
										<div class="col-md-7">
											<div  class="form-control">@if(!empty($particularPro->name)){{$particularPro->name}}@endif</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">  Email <span class="red"></span> : </label>
										<div class="col-md-7">
											<div  class="form-control">@if(!empty($particularPro->email)){{$particularPro->email}}@endif</div>
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-3 control-label">  Your Refferal Code : </label>
										<div class="col-md-7">
											<div  class="form-control">@if(!empty($particularPro->refer_code)){{$particularPro->refer_code}}@endif</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label"> Total Refferal : </label>
										<div class="col-md-7">
											<div  class="form-control">@if(!empty($total_refferal)){{$total_refferal}}@else 0 @endif</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label"> Total Earned Points : </label>
										<div class="col-md-7">
											<div  class="form-control">@if(!empty($total_points)){{$total_points}}@else 0 @endif</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 control-label">Share Refferal Link & earn points : </label>
										<div class="col-md-7">
											<div  class="form-control">
												<a target="_blank" href="@if(!empty($refferal_link)){{$refferal_link}}@endif">@if(!empty($refferal_link)){{$refferal_link}}@endif</a>
											</div>
										</div>
									</div>
								</div>
							</div>


						</div>
					</div>
				</div>
			</div>
		</div>
	</div>






	<!-- END PAGE TITLE-->


@stop

@section('custom_js')
	<script src="{{asset('/phq/assets/global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('/phq/assets/pages/scripts/components-select2.min.js')}}" type="text/javascript"></script>

	<script>




		$(function() {
			$( "#date" ).datepicker({dateFormat: 'yy'});
		});

	</script>

@stop

