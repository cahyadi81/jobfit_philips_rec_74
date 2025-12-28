@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Personality
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($personality, ['route' => ['personalities.update', $personality->id], 'method' => 'patch']) !!}

                        @include('personalities.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection