<!-- User Id Field -->
<div class="col-md-12 no-padding">
    <div class="form-group col-sm-6">
        {!! Form::label('user_id', 'User ID:') !!}
        {!! Form::text('user_id', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Name Field -->
<div class="col-md-12 no-padding">
    <div class="form-group col-sm-6">
        {!! Form::label('name', 'Name:') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Address Field -->
<div class="col-md-12 no-padding">
    <div class="form-group col-sm-6 col-lg-6">
        {!! Form::label('address', 'Address:') !!}
        {!! Form::textarea('address', null, ['class' => 'form-control', 'style' => 'resize: none', 'rows' => '4']) !!}
    </div>
</div>

<!-- Email Field -->
<div class="col-md-12 no-padding">
    <div class="form-group col-sm-6">
        {!! Form::label('email', 'Email:') !!}
        {!! Form::email('email', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Group Field -->
<div class="col-md-12 no-padding">
    <div class="form-group col-sm-6">
        {!! Form::label('group_user_id', 'Group:') !!}
        <select class="form-control select2" id="group_user_id" name="group_user_id" required>
            <option value="">-SELECT-</option>
            @foreach($group as $gr)
                <option value="{!! $gr->group_id !!}">{!! $gr->group_name !!}</option>
            @endforeach
        </select>
    </div>
</div>

@if($show_password)
<!-- Password Field -->
<div class="col-md-12 no-padding">
    <div class="form-group col-sm-6">
        {!! Form::label('password', 'Password:') !!}
        {!! Form::text('password', null, ['class' => 'form-control']) !!}
    </div>
</div>
@endif

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
    <a href="{!! route('users.index') !!}" class="btn btn-default">Cancel</a>
</div>
