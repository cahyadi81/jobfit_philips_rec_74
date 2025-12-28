<!-- Agreement Id Field -->
<div class="col-sm-12 no-padding">
<div class="form-group col-sm-6">
    {!! Form::label('agreement_score', 'Agreement Score:') !!}
    {!! Form::text('agreement_score', null, ['class' => 'form-control', 'maxlength' => '10']) !!}
</div>
</div>

<!-- Norma Field -->
<div class="col-sm-12 no-padding">
<div class="form-group col-sm-6">
    {!! Form::label('norma', 'Norma (%):') !!}
    {!! Form::text('norma', null, ['class' => 'form-control', 'maxlength' => '3']) !!}
</div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('agreementScores.index') !!}" class="btn btn-default">Cancel</a>
</div>
