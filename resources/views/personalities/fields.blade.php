@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
@endsection
<!-- Alias Field -->
<div class="col-sm-12 no-padding">
	<div class="form-group col-sm-6">
	    {!! Form::label('alias', 'Alias:') !!}
	    {!! Form::text('alias', null, ['class' => 'form-control']) !!}
	</div>
</div>

<!-- Personality Name Field -->
<div class="col-sm-12 no-padding">
	<div class="form-group col-sm-6">
	    {!! Form::label('personality_name', 'Personality Name:') !!}
	    {!! Form::text('personality_name', null, ['class' => 'form-control']) !!}
	</div>
</div>

<!-- Description Field -->
<div class="col-sm-12 no-padding">
	<div class="form-group col-sm-6">
	    {!! Form::label('description', 'Description:') !!}
	    {!! Form::textarea('description', null, ['class' => 'form-control textarea', 'style' => 'resize:none']) !!}
	</div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('personalities.index') !!}" class="btn btn-default">Cancel</a>
</div>

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<script>
	$(function(){
    	$(".textarea").wysihtml5();
	})
</script>
@endsection
