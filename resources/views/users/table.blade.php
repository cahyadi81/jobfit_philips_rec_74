<table class="table table-responsive" id="users-table">
    <thead>
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Email</th>
            <th>Group ID</th>
            <th>Status</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{!! $user->user_id !!}</td>
            <td>{!! $user->name !!}</td>
            <td>{!! $user->address !!}</td>
            <td>{!! $user->email !!}</td>
            <td>{!! $user->group_id !!}</td>
            <td>@php
                    $status = $user->status;
                    echo $status == 1 ? 'Active' : 'Non Active';
                @endphp
            <td>
                {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('users.edit', [$user->id]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>