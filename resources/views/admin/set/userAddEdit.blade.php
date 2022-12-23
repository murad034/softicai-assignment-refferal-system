
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
                <a href="{{ URL::to('users/add') }}">Add User</a>
                <i class="fa fa-circle"></i>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->

    <div class="content">
        <div class="col-md-6">
            <h3 class="page-title"> Add User Form </h3>
        </div>
        <div class="btn-group right" style="float:right;padding-top:25px">
            <a href="{{ URL::to('users') }}" class="btn btn-sm blue"> <i class="fa fa-list"> </i> User List</a>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet-body form">



                    {!! Form::open(array('url' => url('users/save'), 'files' => true, 'class'=>'form-horizontal') )  !!}

                        <div class="form-body">

                            @if(!empty($users))
                                <input type="hidden" name="id" value="{{$users->id}}">
                            @endif

                            <div class="form-group">
                                <label class="col-md-5 control-label"> Name <span class="red">*</span> : </label>
                                <div class="col-md-7">
                                    <input type="text" name="name" value="@if(!empty($users->name)){{$users->name}}@else{{old('name')}}@endif" class="form-control input-inline input-medium" placeholder="Enter Name">
                                    <div class="red">{{ $errors->first('name') }}</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-5 control-label"> Email <span class="red">*</span> : </label>
                                <div class="col-md-7">
                                    <input type="email" name="email"  value="@if(!empty($users->email)){{$users->email}}@else{{old('email')}}@endif" placeholder="Enter Unique email" class="form-control input-inline input-medium" >
                                    <div class="red">{{ $errors->first('email') }}</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-5 control-label"> Password <span class="red">*</span> : </label>
                                <div class="col-md-7">
                                    <input type="password" name="password"   placeholder="Enter password" class="form-control input-inline input-medium" >
                                    <div class="red">{{ $errors->first('password') }}</div>
                                </div>
                            </div>
                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Roles<span class="red">*</span>:</label>
                                    <div class="col-lg-7">
                                        <select class="roles_select form-control selectTag" id="roles"  name="roles[]" style="width:35%;">
                                            @if(empty($users))
                                                @if(!empty($roles))
                                                    @foreach($roles as $role)
                                                        <option value="{{$role->name}}">{{$role->name}}</option>
                                                    @endforeach
                                                @endif
                                            @else
                                                @if(!empty($roles))
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->name }}"
                                                                {{ $users->hasrole($role->name) ? 'selected' : null }}>
                                                            {{ $role->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            @endif

                                        </select>
                                        <strong class="red">{{ $errors->first('roles') }}</strong>

                                    </div>
                                </div>

                                @if(!empty($users))
                                <div class="form-group">
                                    <label class="col-md-5 control-label"> Status <span class="red">*</span> : </label>
                                    <div class="col-md-7">
                                        <select class="form-control input-inline input-medium" type="text" name="status"  >
                                                <option @if($users->status==1) selected @endif value=1>Active</option>
                                                <option @if($users->status==0) selected @endif value=0>Inactive</option>
                                        </select>
                                        <div class="red">{{ $errors->first('status') }}</div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-12">
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-5 col-md-6">
                                            <button type="submit" class="btn green">Save</button>
                                            <button type="reset" class="btn default reset">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    {!! Form::close() !!}
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
        function selectTagging() {
            $(".js-example-tokenizer").select2({
                tags: true,
                tokenSeparators: [',', ' ']
            });
            $('.selectTag').select2({
                createTag: function (params) {
                    var term = $.trim(params.term);

                    if (term === '') {
                        return null;
                    }

                    return {
                        id: term,
                        text: term,
                        newTag: true // add additional parameters
                    }
                }
            });
            $('.selectTag').select2({
                createTag: function (params) {
                    // Don't offset to create a tag if there is no @ symbol
                    if (params.term.indexOf('@') === -1) {
                        // Return null to disable tag creation
                        return null;
                    }

                    return {
                        id: params.term,
                        text: params.term
                    }
                }
            });

            $('.selectTag').select2({
                insertTag: function (data, tag) {
                    // Insert the tag at the end of the results
                    data.push(tag);
                }
            });
        }

        $(document).ready(function(){
            selectTagging();

       });


        $(function() {
            $( "#date" ).datepicker({dateFormat: 'yy'});
        });

    </script>

@stop

