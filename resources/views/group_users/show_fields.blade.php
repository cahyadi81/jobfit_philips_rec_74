<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $groupUser->id !!}</p>
</div>

<!-- Group Id Field -->
<div class="form-group">
    {!! Form::label('group_id', 'Group Id:') !!}
    <p>{!! $groupUser->group_id !!}</p>
</div>

<!-- Group Name Field -->
<div class="form-group">
    {!! Form::label('group_name', 'Group Name:') !!}
    <p>{!! $groupUser->group_name !!}</p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    <p>{!! $groupUser->status !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $groupUser->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $groupUser->updated_at !!}</p>
</div>

