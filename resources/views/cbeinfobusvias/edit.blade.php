@extends('layouts.app')
@section('title','Edit cbeInfoBusVias')
@section('pageHeader')
<h1>
   cbeInfoBusVias
   <small>Edit</small>
</h1>
<ol class="breadcrumb">
   <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
   <li><a href="#">cbeInfoBusVias</a></li>
   <li class="active">Edit</li>
</ol>
@endsection
@section('content')
<section class="content">
   <div class="box box-default">
      <div class="box-header with-border">
         <h3 class="box-title">Edit-{{$cbeInfoBusVia->id}}</h3>
         <div class="box-tools pull-right">
            <a href="{{ route('cbeInfoBusVias.index') }}" class="btn bg-purple  btn btn-box-tool"> 
            <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back
            </a>
         </div>
      </div>
      <!-- /.box-header -->
      {!! Form::model($cbeInfoBusVia, ['method' => 'PUT', 'route' => ['cbeInfoBusVias.update',  $cbeInfoBusVia->id ] ,'enctype'=>'multipart/form-data' ]) !!}
        @include('cbeinfobusvias._form')
      {!! Form::close() !!}
   </div>
</section>
@endsection