<table class="table table-responsive" id="jobfitBasics-table">
    <thead>
        <tr>
            <th>Position</th>
            <th>Category Competencies</th>
            <th>Jobfit ID</th>
            <th>Values</th>
            <th>Percent</th>
            <th>Pattern</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($jobfitBasics as $jobfitBasic)
        <tr>
            <td>{!! $jobfitBasic->position($jobfitBasic->position_id)['position_name'] !!}</td>
            <td>{!! $jobfitBasic->categoryCompetency->category_name !!} ({!! $jobfitBasic->categoryCompetency->alias !!})</td>
            <td>{!! $jobfitBasic->jobfit_id !!}</td>
            <td>{!! $jobfitBasic->values !!}</td>
            <td>{!! $jobfitBasic->percent !!}%</td>
            <td>{!! $jobfitBasic->pattern !!}</td>
            <td>
                {!! Form::open(['route' => ['jobfitBasics.destroy', $jobfitBasic->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('jobfitBasics.edit', [$jobfitBasic->id]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>