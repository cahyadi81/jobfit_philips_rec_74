@section('css')
<link rel="stylesheet" href="{{ URL::asset('plugins/datatables/css/datatables.bootstrap.css') }}">
<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        display: unset !important;
        padding: unset !important;
        margin-left: unset !important;
    }
</style>
@endsection

<table class="table table-responsive datatable" id="categoryCompetencies-table" width="100%">
    <thead>
        <tr>
            <th>Alias</th>
            <th>Category Name</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($categoryCompetencies as $categoryCompetency)
        <tr>
            <td>{!! $categoryCompetency->alias !!}</td>
            <td>{!! $categoryCompetency->category_name !!}</td>
            <td>{!! $categoryCompetency->description !!}</td>
            <td>
                {!! Form::open(['route' => ['categoryCompetencies.destroy', $categoryCompetency->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('categoryCompetencies.edit', [$categoryCompetency->id]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

@section('scripts')
<!-- <script src="{{ URL::asset('plugins/datatables/js/datatables.bootstrap.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('categorycompetencies/datatable') }}',
        columns: [
            {data: 'alias', name: 'alias'},
            {data: 'category_name', name: 'category_name'},
            {data: 'description', name: 'description'},
            {data: 'id', render: function (data, type, row) {
                var id = data
                    return ''
                }
            }
        ]
    });
});
</script> -->
@endsection