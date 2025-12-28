@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Quadran Competency
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($quadranCompetency, ['route' => ['quadranCompetencies.update', $quadranCompetency->id], 'method' => 'patch']) !!}

                        @include('quadran_competencies.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection