@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Question Competency
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($questionCompetency, ['route' => ['questionCompetencies.update', $questionCompetency->id], 'method' => 'patch']) !!}

                        @include('question_competencies.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
@section('scripts')
    <script>
        $(function() {
            $('.select2').select2();
            $('.select2').val('{!! $questionCompetency->category_competencies_id !!}').trigger("change");
        });
    </script>
@endsection