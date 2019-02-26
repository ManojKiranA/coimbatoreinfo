@push('styles')
<style>
   [class^='select2'] {
   border-radius: 0px !important;
   }
</style>
@foreach(config('cinfoConstants.desgins.backend.busPageCss') as $cssFileComment => $cssFileUrl)
<!-- {{$cssFileComment}} -->
{{Html::style($cssFileUrl)}}
@endforeach
@endpush
<div class="box-body">
   {{-- Row  Starts --}}
   <div class="row">
      <div class="col-sm-6">
         <div class="form-group @if ($errors->has('bus_point_from')) has-error @endif">
            {!! Form::label('bus_point_from','Bus Starting Point') !!}
            {!! Form::select('bus_point_from', $busFromArray, null, ['class' =>'form-control select2','id' => 'bus_point_from']) !!}
            @if ($errors->has('bus_point_from'))
            <p class="help-block">{{ $errors->first('bus_point_from') }}</p>
            @endif
         </div>
      </div>
      <div class="col-sm-6">
         <div class="form-group @if ($errors->has('bus_point_to')) has-error @endif">
            {!! Form::label('bus_point_to','Bus Reaching Point') !!}
            {!! Form::select('bus_point_to', $busToArray, null, ['class' =>'form-control select2','id' => 'bus_point_to']) !!}
            @if ($errors->has('bus_point_to'))
            <p class="help-block">{{ $errors->first('bus_point_to') }}</p>
            @endif
         </div>
      </div>
   </div>
   {{-- Row  Ends --}}
   {{-- Row  Starts --}}
   <div class="row">
      <div class="col-sm-6">
         <div class="form-group @if ($errors->has('bus_id')) has-error @endif">
            {!! Form::label('bus_id','Bus Name') !!}
            {!! Form::select('bus_id', $busNameArray, null, ['class' =>'form-control','id' => 'bus_id']) !!}
            @if ($errors->has('bus_id'))
            <p class="help-block">{{ $errors->first('bus_id') }}</p>
            @endif
         </div>
      </div>
      <div class="col-sm-6">
         <div class="form-group @if ($errors->has('bus_type_id')) has-error @endif">
            {!! Form::label('bus_type_id','Bus Type') !!}
            {!! Form::select('bus_type_id', $busTypeArray, null, ['class' =>'form-control select2','id' => 'bus_type_id']) !!}
            @if ($errors->has('bus_type_id'))
            <p class="help-block">{{ $errors->first('bus_type_id') }}</p>
            @endif
         </div>
      </div>
   </div>
   {{-- Row  Ends --}}
   {{-- Row  Starts --}}
   <div class="row">
      <div class="col-sm-6">
         <div class="form-group @if ($errors->has('bus_route_id')) has-error @endif">
            {!! Form::label('bus_route_id','Bus Via') !!}
            {!! Form::select('bus_route_id', $busRouteArray, null, ['class' =>'form-control select2','id' => 'bus_route_id']) !!}
            @if ($errors->has('bus_route_id'))
            <p class="help-block">{{ $errors->first('bus_route_id') }}</p>
            @endif
         </div>
      </div>
      <div class="col-sm-6">
         <div class="form-group @if ($errors->has('bus_time')) has-error @endif">
            {!! Form::label('bus_time','Bus Time') !!}
            {!! Form::text('bus_time',old('bus_time'),['placeholder'=>'Enter Bus Time','class' =>'form-control','id' =>'bus_time']) !!}
            @if ($errors->has('bus_time'))
            <p class="help-block">{{ $errors->first('bus_time') }}</p>
            @endif
         </div>
      </div>
   </div>
   {{-- Row  Ends --}}
</div>
<!-- /.box-body -->
<div class="box-footer">
   {{ Form::button('<i class="fa fa-save"></i> Save', ['type' => 'submit', 'class' => 'btn bg-purple btn-flat margin pull-right'] )  }}
   {{ Form::button('<i class="fa fa-eraser"></i> Clear', ['type' => 'reset', 'class' => 'btn bg-red btn-flat margin pull-left'] )  }}
</div>
<!-- /.box-footer -->
@push('scripts')
@foreach(config('cinfoConstants.desgins.backend.busPageJs') as $jsFileComment => $jsFileUrl)
<!-- {{$jsFileComment}} -->
{{Html::script($jsFileUrl)}}
@endforeach  
<script type="text/javascript">
   $(function () {
        $('#bus_point_from').select2({});
        $('#bus_point_to').select2({});
        $('#bus_time').timepicker({showInputs: false});
        $('#bus_route_id').select2({});
        $('#bus_id').select2({});
        $('#bus_type_id').select2({});
        
        
        
        
        
   });
</script>
@endpush