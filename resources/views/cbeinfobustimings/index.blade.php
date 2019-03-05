@extends('layouts.app')

@section('title','cbeInfoBusTimings List')

@section('pageHeader')
  <h1>
    cbeInfoBusTimings
    <small>List</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">cbeInfoBusTimings</a></li>
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
              <h3 class="box-title">{{ $cbeInfoBusTimings->total() }} {{ str_plural('cbeInfoBusTiming', $cbeInfoBusTimings->count()) }}</h3>
              <div class="box-tools">
                <a href="{{ route('cbeInfoBusTimings.create') }}" class="btn bg-purple  btn btn-box-tool"> 
                  <i class="fa fa-plus"></i>&nbsp;&nbsp;Create
                </a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>ID</th>
                  <th>Bus Name</th>
                  <th>Bus Type</th>
                  <th>Bus Route</th>
                  <th>Bus Starting Point</th>
                  <th>Bus Reaching Point</th>
                  <th>Created On</th>
                  <th>Created By</th>
                  <th>Actions</th>
                </tr>
                @foreach($cbeInfoBusTimings as $item)
                <tr>
                  <td>{{ ($cbeInfoBusTimings ->currentpage()-1) * $cbeInfoBusTimings ->perpage() + $loop->index + 1 }}</td>
                  <td>{{$item->busName['bus_name']}}</td>
                  <td>{{$item->busType['bus_type_name']}}</td>
                  <td>{{$item->busRouteName['bus_via_name'] }}</td>
                  <td>{{$item->busStartingPoint['location_from_name']}}</td>
                  <td>{{$item->busReachingPoint['location_to_name']}}</td>
                  <td>{{ApplicationHelper::convertToFormattedDate($item->created_at,1)}}</td>
                  <td>{{$item->createdBy['name']}}</td>
                  <td class="text-center">
                   {{ BladeHelper::tableActionButtons(url()->full(),$item->id,$item->id,['edit','delete'],null,false) }}
                 </td>
                </tr>
                @endforeach
              </table>
              <center>
                {{$cbeInfoBusTimings->links()}}  
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
