@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Category Competency
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($categoryCompetency, ['route' => ['categoryCompetencies.update', $categoryCompetency->id], 'method' => 'patch']) !!}

                        @include('category_competencies.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection