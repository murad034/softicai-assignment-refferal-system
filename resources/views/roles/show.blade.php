@extends('layouts.user')

@section('custom_css')
<!-- <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" /> -->
<style>

.form-check-label{
    margin-bottom:0;
    text-transform:capitalize;
}
</style>
@endsection
@section('content')
<div class="page-breadcrumbs">
                    <ul class="breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="{{ URL::to('/') }}">Dashboard</a>
                        </li>
                        <li>
                            <a href="#">Roles View-{{$role->name}}</a>
                        </li>

                    </ul>
                </div>
    <div class="container-fluid" style="margin-top:10px">
   
     

        <div class="widget">
            <div class="widget-header bordered-top bordered-darkorange">
                <span class="widget-caption"></span>
            </div>
            <div class="widget-body">
                <div class="collapse in">
                    <div class="create-page">
                        <form action="{{ route('roles.show',$role->id) }}" method="POST" enctype="multipart/form-data" data-parsley-validate data-parsley-focus="first">
                        @method('PUT')
                            @csrf
                            <div class="form-body">
                                <div class="card-body">
                                    <div class="row ">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="name">Role Name </label>*<span class="border p-2">{{$role->name }}</span>
                                        </div>
                                    </div>
                                    </div>
                                    
            
                                  
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="control-label" for="allManagement">Permissions 
                                                
                                            </label>
                                        </div>



                                        
                                        <div class="col-md-9">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkPermissionAll" value="1" {{App\User::roleHasPermissions($role,$all_permissions) ? 'checked' : ''}} disabled>
                                                <label class="custom-control-label" for="checkPermissionAll">
                                                
                                                    <strong>All</strong>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>


                                            @php $i=1; @endphp

                                            @foreach ($permission_groups as $group) 
                                            <div class="row">
                                            @php
                                            
                                            $permissions = \App\User::getPermissionsByGroupName($group->name);
                                        
                                             $j=1; 
                                             @endphp
                                            <div class="col-md-3">
                                            
                                            <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="{{$i}}Management" value="{{$group->name}}" onclick="checkPermissionByGroup('role-{{$i}}-management-checkbox',this)"{{App\User::roleHasPermissions($role,$permissions) ? 'checked' : ''}} disabled>
                                            
                                           
                                              
                                                <label class="form-check-label" for="checkPermission">
                                               {{$group->name}}
                                                </label>
                                            </div>
                                           
                                            </div>
                                            <div class="col-md-9 role-{{$i}}-management-checkbox">
                                            
                                            
                                            @foreach ($permissions as $permission) 
                                            <div class="form-check">              
                                            <input type="checkbox" class="form-check-input" onclick="checkSinglePermission('role-{{$i}}-management-checkbox','{{$i}}Management',{{count($permissions)}})" name="permissions[]" {{$role->hasPermissionTo($permission->name) ? 'checked' : '' }} id="checkPermission{{$permission->id}}" value="{{$permission->name}}" disabled>

                                            
                                            
                                           
                                              
                                                <label class="form-check-label" for="checkPermission{{$permission->id}}">
                                               {{$permission->name}}
                                                </label>
                                            </div>
                                            @php 
                                            $j++;
                                            
                                             @endphp
                                            @endforeach 
                                            <br>
                                        
                                            
                                            </div>
                                            </div>
                                            @php $i++; @endphp

                                            @endforeach

                                    </div>
            
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <div class="form-actions">
                                                <div class="card-body">
                                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-success"> <i class="fa fa-arrow-left"></i> Edit Now</a>
                                                <a href="{{ route('roles.index') }}" class="btn btn-dark">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')


     @include('roles.partials.scripts'); 
    
@endsection