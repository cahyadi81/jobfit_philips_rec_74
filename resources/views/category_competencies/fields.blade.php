<!-- Alias Field -->
<div class="col-sm-12 no-padding">
<div class="form-group col-sm-6">
    {!! Form::label('alias', 'Alias:') !!}
    {!! Form::text('alias', null, ['class' => 'form-control']) !!}
</div>
</div>

<!-- Category Name Field -->
<div class="col-sm-12 no-padding">
<div class="form-group col-sm-6">
    {!! Form::label('category_name', 'Category Name:') !!}
    {!! Form::text('category_name', null, ['class' => 'form-control']) !!}
</div>
</div>

<!-- Description Field -->
<div class="col-sm-12 no-padding">
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('categoryCompetencies.index') !!}" class="btn btn-default">Cancel</a>
</div>
