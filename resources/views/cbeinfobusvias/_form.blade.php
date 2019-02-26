<div class="box-body">
   {{-- Row  Starts --}}
   <div class="row">
      <div class="col-sm-5">
         <div class="form-group @if ($errors->has('bus_via_name')) has-error @endif">
            {!! Form::label('bus_via_name','Name') !!}
               {!! Form::text('bus_via_name',old('bus_via_name'),['placeholder'=>'Enter Bus Via Name','class' =>'form-control rounded','id' =>'bus_via_name']) !!}
               @if ($errors->has('bus_via_name'))
               <p class="help-block">{{ $errors->first('bus_via_name') }}</p>
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

