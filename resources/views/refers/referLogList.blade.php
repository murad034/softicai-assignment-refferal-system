
@extends('layouts.user')
@section('custom_css')
    <link href="{{asset('phq/assets/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('phq/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .select2-selection--single{
            height: 24px !important;
            padding: 2px 8px !important;
        }
        .form-control{
            height: 24px !important;
            padding: 2px 8px !important;
        }
    </style>
@stop


@section('content')

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{ URL::to('/adminUser') }}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ URL::to('referList') }}">Referral List</a>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <div class="content">
        <div class="col-md-6">
            <h3 class="page-title"> Referral List</h3>
        </div>

    </div>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="tools"> </div>
                </div>
                <div class="portlet-body">
                    <div class="">
                        <table class="table  table-striped table-bordered table-hover" id="referLogTable" style="width:100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Total Refer</th>
                            <th>Total Point</th>
                            <th>Refferal</th>
                            <th>Created Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    </div>
    <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->



@stop


@section('custom_js')
    <script src="{{asset('phq/assets/global/scripts/datatable.js')}}" type="text/javascript"></script>
    <script src="{{asset('phq/assets/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('phq/assets/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('phq/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
    <script>

    </script>
    <script>
        const ajaxURL = "{{\Illuminate\Support\Facades\URL::to('referList')}}";
        var table = $('table#referLogTable').DataTable({
            dom: 'Blfrtip',
            language: {processing: "<span class='loading-datatable'><span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Loading Data...</span>"},
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: ajaxURL,
                data: function (d){

                },
            },
            order: [[0, "desc"]],
            aLengthMenu: [[25, 50, 100, 1000, -1], [25, 50, 100, 1000, "All"]],
            buttons: [

            ],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'total_refer', name: 'total_refer', orderable: false, searchable: false },
                {data: 'total_point', name: 'total_point', orderable: false, searchable: false },
                {data: 'referrer', name: 'referrer', orderable: false, searchable: false },
                {data: 'created_at', name: 'created_at'},
            ]
        });
    </script>

    <script>
        $(document).ready(function(){

        });
    </script>
@stop




















