@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('plugins/datatables/css/datatables.bootstrap.css') }}">
@endsection

@section('content')
    <section class="content-header">
        <h1>Results Job Fit</h1>
        <h1>
           <a class="btn btn-success" style="margin-top: 10px;margin-bottom: 5px" href="{!! route('results-excel') !!}"><i class="fa fa-file-excel-o"></i> &nbsp; Export All To Excel</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('results.table')
            </div>
        </div>
        <div class="text-center">
        
       
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{ URL::asset('plugins/datatables/js/jquery.datatables.min.js') }}"></script>
<script src="{{ URL::asset('plugins/datatables/js/datatables.bootstrap.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
    var url = '{{ URL::to("/") }}';
    $('.datatable').dataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('results-datable') }}',
        columns: [
            {data: 'nik', name: 'nik'},
            {data: 'nama', name: 'nama'},
            {data: 'position_name', name: 'position_name'},
            {data: 'last_test', name: 'last_test'},
            {data: function (data, type, dataToSet) {
                    if(type === 'display'){
                        data = '<a href="'+ url+'/results/' + data.nik + '_' + data.last_test +'"><button class="btn btn-default">Preview</button></a> '+
                               '   <a href="'+ url+'/results-pdf/' + data.nik + '_' + data.last_test +'"><button class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Export</button></a>';
                    }

                    return data;
                    }, orderable: false, searchable: false}
        ]
    });
});
</script>
@endsection

