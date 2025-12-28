<table class="table table-responsive" id="agreementScores-table">
    <thead>
        <tr>
            <th>Agreement Score</th>
            <th>Norma</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($agreementScores as $agreementScore)
        <tr>
            <td>{!! $agreementScore->agreement_score !!}</td>
            <td>{!! $agreementScore->norma !!}%</td>
            <td>
                {!! Form::open(['route' => ['agreementScores.destroy', $agreementScore->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('agreementScores.edit', [$agreementScore->id]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>