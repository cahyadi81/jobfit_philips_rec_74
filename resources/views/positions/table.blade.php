<table class="table table-responsive" id="positions-table">
    <thead>
        <tr>
            <th>Position Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($positions as $position)
        <tr>
            <td>{!! $position->position_name !!}</td>
            <td>@php
                    $status = $position->status;
                    echo $status == 1 ? 'Active' : 'Non Active';
                @endphp</td>
            <td>
                {!! Form::open(['route' => ['positions.destroy', $position->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('positions.edit', [$position->id]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>