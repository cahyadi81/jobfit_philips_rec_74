@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Jobfit Basic
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($jobfitBasic, ['route' => ['jobfitBasics.update', $jobfitBasic->id], 'method' => 'patch']) !!}

                        @include('jobfit_basics.fields')

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
            $('.category-competencies').val('{!! $jobfitBasic->category_competencies_id !!}').trigger("change");
            $('.position').val('{!! $jobfitBasic->position_id !!}').trigger("change");
        });
    </script>
@endsection