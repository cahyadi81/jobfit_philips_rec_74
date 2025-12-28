<table class="table table-responsive datatable" id="results-table">
    <thead>
        <tr>
            <th>NIK</th>
            <th>Name</th>
            <th>Position</th>
            <th>Tanggal Test</th>
            <th>Process</th>
        </tr>
    </thead>
    <tbody>

       <!--  @php
            $no = 0;
        @endphp

        @foreach($results as $result)
            @php
            $no++;
            $id = $result->nik.'_'.strtotime($result->last_test);
            @endphp
            <tr>
                <td>{!! $no !!}</td>
                <td>{!! $result->nik !!}</td>
                <td>{!! $result->nama !!}</td>
                <td>{!! $result->position_name !!}</td>
                <td>{!! date('d-m-Y', strtotime($result->last_test)) !!}</td>
                <td>
                    <a href="{!! route('results.show', [$id]) !!}"><button class="btn btn-default">Preview</button></a>
                    <a href="{!! route('results-pdf', [$id]) !!}"><button class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Export</button></a>
                </td>
            </tr>
        @endforeach -->
    </tbody>
</table>