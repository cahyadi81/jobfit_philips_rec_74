@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Agreement Score
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($agreementScore, ['route' => ['agreementScores.update', $agreementScore->id], 'method' => 'patch']) !!}

                        @include('agreement_scores.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection