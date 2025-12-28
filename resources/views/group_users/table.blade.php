<table class="table table-responsive" id="groupUsers-table">
    <thead>
        <tr>
            <th>Group ID</th>
            <th>Group Name</th>
            <th>Status</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($groupUsers as $groupUser)
        <tr>
            <td>{!! $groupUser->group_id !!}</td>
            <td>{!! $groupUser->group_name !!}</td>
            <td>
                @php
                    $status = $groupUser->status;
                    echo $status == 1 ? 'Active' : 'Non Active';
                @endphp
            </td>
            <td>
                {!! Form::open(['route' => ['groupUsers.destroy', $groupUser->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('groupUsers.edit', [$groupUser->id]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>