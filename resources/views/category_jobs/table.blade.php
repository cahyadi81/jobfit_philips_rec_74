<table class="table table-responsive" id="categoryJobs-table">
    <thead>
        <tr>
            <th>Job Position</th>
            <th>Category Competencies</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @php
        if(count($categoryJobs) == 0){

        } else {
    @endphp
        @foreach($categoryJobs as $categoryJob)
            <tr>
                <td>{!! $categoryJob->position($categoryJob->position_id)['position_name'] !!}</td>
                <td>{!! $categoryJob->categoryCompetency->category_name !!} ({!! $categoryJob->categoryCompetency->alias !!})</td>
                <td>
                    {!! Form::open(['route' => ['categoryJobs.destroy', $categoryJob->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('categoryJobs.edit', [$categoryJob->id]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    @php
        }
    @endphp
    </tbody>
</table>