@extends('layouts.app')
@section('title','Edit cbeInfoBusTimings')
@section('pageHeader')
<h1>
   cbeInfoBusTimings
   <small>Edit</small>
</h1>
<ol class="breadcrumb">
   <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
   <li><a href="#">cbeInfoBusTimings</a></li>
   <li class="active">Edit</li>
</ol>
@endsection
@section('content')
<section class="content">
   <div class="box box-default">
      <div class="box-header with-border">
         <h3 class="box-title">Edit-{{$cbeInfoBusTiming->id}}</h3>
         <div class="box-tools pull-right">
            <a href="{{ route('cbeInfoBusTimings.index') }}" class="btn bg-purple  btn btn-box-tool"> 
            <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back
            </a>
         </div>
      </div>
      <!-- /.box-header -->
      {!! Form::model($cbeInfoBusTiming, ['method' => 'PUT', 'route' => ['cbeInfoBusTimings.update',  $cbeInfoBusTiming->id ] ,'enctype'=>'multipart/form-data' ]) !!}
        @include('cbeinfobustimings._form')
      {!! Form::close() !!}
   </div>
</section>
@endsection