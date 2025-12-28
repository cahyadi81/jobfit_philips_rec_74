@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Tes
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($tes, ['route' => ['tes.update', $tes->id], 'method' => 'patch']) !!}

                        @include('tes.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection