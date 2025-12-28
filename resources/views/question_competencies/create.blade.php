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
                    {!! Form::open(['route' => 'questionCompetencies.store']) !!}

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
        });
    </script>
@endsection
