<table class="table table-responsive" id="quadranIndividuals-table">
    <thead>
        <tr>
            <th>Quatril</th>
            <th>Min</th>
            <th>Max</th>
            <th><div align="center">Action</div></th>
        </tr>
    </thead>
    <tbody>
    @foreach($quadranIndividuals as $quadranIndividual)
        <tr>
            <td>{!! $quadranIndividual->quatril !!}</td>
            <td>{!! $quadranIndividual->min !!}</td>
            <td>{!! $quadranIndividual->max !!}</td>
            <td align="center">
                {!! Form::open(['route' => ['quadranIndividuals.destroy', $quadranIndividual->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('quadranIndividuals.edit', [$quadranIndividual->id]) !!}" class='btn btn-default btn-sm'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>