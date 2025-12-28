<!-- Question Id Field -->
<div class="col-md-12 no-padding">
    <div class="form-group col-sm-6">
        {!! Form::label('question_id', 'Question ID:') !!}
        {!! Form::text('question_id', null, ['class' => 'form-control', 'maxlength' => '10']) !!}
    </div>
</div>

<!-- Categori Id Field -->
<div class="col-md-12 no-padding">
    <div class="form-group col-sm-6">
        {!! Form::label('category_id', 'Categori Competencies:') !!}
        <!-- {!! Form::text('categori_id', null, ['class' => 'form-control']) !!} -->
        <select class="form-control select2" name="category_competencies_id" id="category_competencies_id" required="true">
            <option value="">-SELECT-</option>
            @foreach($category as $categories)
                <option value="{!! $categories->id !!}">{!! $categories->category_name !!}</option>
            @endforeach
        </select>
    </div>
</div>

<!-- Description Field -->
<div class="col-md-12 no-padding">
    <div class="form-group col-sm-6">
        {!! Form::label('description', 'Description:') !!}
        {!! Form::textarea('description', null, ['class' => 'form-control', 'style' => 'resize:none']) !!}
    </div>
</div>

<!-- Coding Field -->
<div class="col-md-12 no-padding">
    <div class="form-group col-sm-6">
        {!! Form::label('coding', 'Coding:') !!}
        {!! Form::text('coding', null, ['class' => 'form-control', 'maxlength' => '5']) !!}
    </div>
</div>

<!-- Jobfit Field -->
<div class="col-md-12 no-padding">
    <div class="form-group col-sm-6">
        {!! Form::label('jobfit_id', 'Jobfit ID:') !!}
        {!! Form::text('jobfit_id', null, ['class' => 'form-control', 'maxlength' => '1']) !!}
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('questionCompetencies.index') !!}" class="btn btn-default">Cancel</a>
</div>
