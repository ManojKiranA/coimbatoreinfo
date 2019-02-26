@extends('layouts.app')
@section('title','Edit To Location')
@section('pageHeader')
<h1>
   To Location
   <small>Edit</small>
</h1>
<ol class="breadcrumb">
   <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
   <li><a href="#">To Location</a></li>
   <li class="active">Edit</li>
</ol>
@endsection
@section('content')
<section class="content">
   <div class="box box-default">
      <div class="box-header with-border">
         <h3 class="box-title">Edit-{{$cbeInfoLocationTo->location_to_name}}</h3>
         <div class="box-tools pull-right">
            <a href="{{ route('cbeInfoLocationTos.index') }}" class="btn bg-purple  btn btn-box-tool"> 
            <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back
            </a>
         </div>
      </div>
      <!-- /.box-header -->
      {!! Form::model($cbeInfoLocationTo, ['method' => 'PUT', 'route' => ['cbeInfoLocationTos.update',  $cbeInfoLocationTo->id ] ,'enctype'=>'multipart/form-data' ]) !!}
        @include('cbeinfolocationtos._form')
      {!! Form::close() !!}
   </div>
</section>
@endsection