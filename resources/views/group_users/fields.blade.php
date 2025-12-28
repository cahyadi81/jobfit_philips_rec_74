<!-- Group Id Field -->
<div class="col-md-12 no-padding">
	<div class="form-group col-sm-6">
	    {!! Form::label('group_id', 'Group ID:') !!}
	    {!! Form::text('group_id', null, ['class' => 'form-control']) !!}
	</div>
</div>

<!-- Group Name Field -->
<div class="col-md-12 no-padding">
	<div class="form-group col-sm-6">
	    {!! Form::label('group_name', 'Group Name:') !!}
	    {!! Form::text('group_name', null, ['class' => 'form-control']) !!}
	</div>
</div>

<!-- Status Field -->
<div class="col-md-12 no-padding">
	<div class="form-group col-sm-6">
	    {!! Form::label('status', 'Status:') !!}
	    {!! Form::select('status', ['1' => 'Active', '0' => 'Non Active'], null, ['class' => 'form-control select2']) !!}
	</div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('groupUsers.index') !!}" class="btn btn-default">Cancel</a>
</div>
