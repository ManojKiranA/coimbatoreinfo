@extends('layouts.app')

@section('title','To Location List')

@section('pageHeader')
  <h1>
    To Location
    <small>List</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">To Location</a></li>
    <li class="active">List</li>
  </ol>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">{{ $cbeInfoLocationTos->total() }} {{ str_plural('To Location', $cbeInfoLocationTos->count()) }}</h3>
              <div class="box-tools">
                <a href="{{ route('cbeInfoLocationTos.create') }}" class="btn bg-purple  btn btn-box-tool"> 
                  <i class="fa fa-plus"></i>&nbsp;&nbsp;Create
                </a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>ID</th>
                  <th>Location Name</th>
                  <th>Created On</th>
                  <th>Created By</th>
                  <th>Actions</th>
                </tr>
                @foreach($cbeInfoLocationTos as $item)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$item->location_to_name}}</td>
                  <td>{{ApplicationHelper::convertToFormattedDate($item->created_at,1)}}</td>
                  <td>{{$item->createdBy['name']}}</td>
                  <td class="text-center">
                   {{ BladeHelper::tableActionButtons(url()->full(),$item->id,$item->location_to_name,['edit','delete'],null,false) }}
                 </td>
                 
                </tr>
                @endforeach
              </table>
              <center>
                {{$cbeInfoLocationTos->links()}}  
              </center>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->
@endsection
