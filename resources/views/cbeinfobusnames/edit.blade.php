@extends('layouts.app')
@section('title','Edit cbeInfoBusNames')
@section('pageHeader')
<h1>
   cbeInfoBusNames
   <small>Edit</small>
</h1>
<ol class="breadcrumb">
   <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
   <li><a href="#">cbeInfoBusNames</a></li>
   <li class="active">Edit</li>
</ol>
@endsection
@section('content')
<section class="content">
   <div class="box box-default">
      <div class="box-header with-border">
         <h3 class="box-title">Edit-{{$cbeInfoBusName->id}}</h3>
         <div class="box-tools pull-right">
            <a href="{{ route('cbeInfoBusNames.index') }}" class="btn bg-purple  btn btn-box-tool"> 
            <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back
            </a>
         </div>
      </div>
      <!-- /.box-header -->
      {!! Form::model($cbeInfoBusName, ['method' => 'PUT', 'route' => ['cbeInfoBusNames.update',  $cbeInfoBusName->id ] ,'enctype'=>'multipart/form-data' ]) !!}
        @include('cbeinfobusnames._form')
      {!! Form::close() !!}
   </div>
</section>
@endsection