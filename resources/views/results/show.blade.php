@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Laporan Assessment
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="panel-heading">
                <button class="btn btn-default" onclick="history.back()">BACK</button>
            </div>
            <div class="box-body">
                <div class="row" style="padding: 40px">
                    @include('results.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
