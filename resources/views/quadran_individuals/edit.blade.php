@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Quadran Individual
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($quadranIndividual, ['route' => ['quadranIndividuals.update', $quadranIndividual->id], 'method' => 'patch']) !!}

                        @include('quadran_individuals.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection