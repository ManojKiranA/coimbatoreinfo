@extends('layouts.app')
@section('title','Edit cbeInfoBusTypes')
@section('pageHeader')
<h1>
   Bus Types
   <small>Edit</small>
</h1>
<ol class="breadcrumb">
   <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
   <li><a href="#">BusTypes</a></li>
   <li class="active">Edit</li>
</ol>
@endsection
@section('content')
<section class="content">
   <div class="box box-default">
      <div class="box-header with-border">
         <h3 class="box-title">Edit-{{$cbeInfoBusType->bus_type_name}}</h3>
         <div class="box-tools pull-right">
            <a href="{{ route('cbeInfoBusTypes.index') }}" class="btn bg-purple  btn btn-box-tool">
            <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back
            </a>
         </div>
      </div>
      <!-- /.box-header -->
      {!! Form::model($cbeInfoBusType, ['method' => 'PUT', 'route' => ['cbeInfoBusTypes.update',  $cbeInfoBusType->id ] ,'enctype'=>'multipart/form-data' ]) !!}
        @include('cbeinfobustypes._form')
      {!! Form::close() !!}
   </div>
</section>
@endsection
