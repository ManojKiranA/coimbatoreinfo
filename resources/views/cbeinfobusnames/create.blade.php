@extends('layouts.app')
@section('title','Create New cbeInfoBusNames')
@section('pageHeader')
<h1>
   cbeInfoBusNames
   <small>Create</small>
</h1>
<ol class="breadcrumb">
   <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
   <li><a href="#">cbeInfoBusNames</a></li>
   <li class="active">Create</li>
</ol>
@endsection
@section('content')
<section class="content">
   <div class="box box-default">
      <div class="box-header with-border">
         <h3 class="box-title">Create New</h3>
         <div class="box-tools pull-right">
            <a href="{{ route('cbeInfoBusNames.index') }}" class="btn bg-purple  btn btn-box-tool"> 
            <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back
            </a>
         </div>
      </div>
      <!-- /.box-header -->
      {!! Form::open(['route' => ['cbeInfoBusNames.store'],'autocomplete' => 'off','files' => 'true','enctype'=>'multipart/form-data' ]) !!}
                @include('cbeinfobusnames._form')
      {!! Form::close() !!}
   </div>
</section>
@endsection
