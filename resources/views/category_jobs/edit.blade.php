@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Category Job
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($categoryJob, ['route' => ['categoryJobs.update', $categoryJob->id], 'method' => 'patch']) !!}

                        @include('category_jobs.fields')

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
            $('.select2').val('{!! $categoryJob->category_competencies_id !!}').trigger("change");
        });
    </script>
@endsection