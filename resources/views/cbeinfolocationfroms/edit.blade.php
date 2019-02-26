@extends('layouts.app')
@section('title','Edit Location')
@section('pageHeader')
<h1>
   From Location
   <small>Edit</small>
</h1>
<ol class="breadcrumb">
   <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
   <li><a href="#">From Location</a></li>
   <li class="active">Edit</li>
</ol>
@endsection
@section('content')
<section class="content">
   <div class="box box-default">
      <div class="box-header with-border">
         <h3 class="box-title">Edit-{{$cbeInfoLocationFrom->location_from_name}}</h3>
         <div class="box-tools pull-right">
            <a href="{{ route('cbeInfoLocationFroms.index') }}" class="btn bg-purple  btn btn-box-tool"> 
            <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back
            </a>
         </div>
      </div>
      <!-- /.box-header -->
      {!! Form::model($cbeInfoLocationFrom, ['method' => 'PUT', 'route' => ['cbeInfoLocationFroms.update',  $cbeInfoLocationFrom->id ] ,'enctype'=>'multipart/form-data' ]) !!}
      @include('cbeinfolocationfroms._form')
      {!! Form::close() !!}
   </div>
</section>
@endsection