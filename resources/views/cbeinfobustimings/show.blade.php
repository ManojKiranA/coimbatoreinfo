@extends('layouts.app')
@section('title', '{{Title}}')
@section('breadcrumb')
@stop
@section('content')
    
    <div class="row">
        <div class="col-md-12">
            <div class="box-header b-b">
                <div class="row">
                    <div class="col-md-5">
                        <h3> {{Title}}</h3>
                    </div>
                    <div class="col-md-7 page-action text-right">
                         <a href="{{ route('cbeInfoBusTimings.index') }}" class="btn btn-default btn-sm"> <i class="fa fa-arrow-left"></i> Back</a>
                    </div>
                </div>
            </div>  
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tbody>

                <tr>
                    <th>Id</th>
                    <td>{{ $cbeInfoBusTiming->id }} </td>
                </tr>
                
            </tbody>    
        </table>
    </div>

@endsection