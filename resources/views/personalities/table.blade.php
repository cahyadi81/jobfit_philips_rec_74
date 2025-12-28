<table class="table table-responsive" id="personalities-table">
    <thead>
        <tr>
            <th>Alias</th>
            <th>Personality Name</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($personalities as $personality)
        <tr>
            <td>{!! $personality->alias !!}</td>
            <td>{!! $personality->personality_name !!}</td>
            <td>
                {!! Form::open(['route' => ['personalities.destroy', $personality->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('personalities.show', [$personality->id]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('personalities.edit', [$personality->id]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>