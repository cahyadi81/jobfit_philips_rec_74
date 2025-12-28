<table class="table table-responsive" id="quadranScores-table">
    <thead>
        <tr>
            <th>Quatril</th>
            <th>Score</th>
            <th colspan="3"><div align="center">Action</div></th>
        </tr>
    </thead>
    <tbody>
    @foreach($quadranScores as $quadranScore)
        <tr>
            <td>{!! $quadranScore->quatril !!}</td>
            <td>{!! $quadranScore->score !!}</td>
            <td align="center">
                {!! Form::open(['route' => ['quadranScores.destroy', $quadranScore->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('quadranScores.edit', [$quadranScore->id]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>