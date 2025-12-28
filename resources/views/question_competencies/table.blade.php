<table class="table table-responsive" id="questionCompetencies-table">
    <thead>
        <tr>
            <th>Categori Competencies</th>
            <th width="40%">Description</th>
            <th>Coding</th>
            <th>Jobfit ID</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($questionCompetencies as $questionCompetency)
        <tr>
            <td>{!! $questionCompetency->categoryCompetency->category_name !!} ({!! $questionCompetency->categoryCompetency->alias !!})</td>
            <td>{!! $questionCompetency->description !!}</td>
            <td>{!! $questionCompetency->coding !!}</td>
            <td>{!! $questionCompetency->jobfit_id !!}</td>
            <td>
                {!! Form::open(['route' => ['questionCompetencies.destroy', $questionCompetency->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('questionCompetencies.edit', [$questionCompetency->id]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>