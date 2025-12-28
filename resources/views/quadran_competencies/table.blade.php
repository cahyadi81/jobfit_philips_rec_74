<table class="table table-responsive" id="quadranCompetencies-table">
    <thead>
        <tr>
            <th>Quatril</th>
            <th>Min</th>
            <th>Max</th>
            <th><div align="center">Action</div></th>
        </tr>
    </thead>
    <tbody>
    @foreach($quadranCompetencies as $quadranCompetency)
        <tr>
            <td>{!! $quadranCompetency->quatril !!}</td>
            <td>{!! $quadranCompetency->min !!}%</td>
            <td>{!! $quadranCompetency->max !!}%</td>
            <td align="center">
                {!! Form::open(['route' => ['quadranCompetencies.destroy', $quadranCompetency->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('quadranCompetencies.edit', [$quadranCompetency->id]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>