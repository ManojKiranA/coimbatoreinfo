<div class="box-body">
   {{-- Row  Starts --}}
   <div class="row">
      <div class="col-sm-5">
         <div class="form-group @if ($errors->has('location_from_name')) has-error @endif">
            {!! Form::label('location_from_name','Location Name') !!}
            {!! Form::text('location_from_name',old('location_from_name'),['placeholder'=>'Enter Location Name','class' =>'form-control rounded','id' =>'location_from_name']) !!}
            @if ($errors->has('location_from_name'))
            <p class="help-block">{{ $errors->first('location_from_name') }}</p>
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