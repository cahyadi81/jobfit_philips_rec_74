@section('css')
    <style>
        .tag-rahasia {
            color: #000;
            background-color: #92d050;
            padding: 4px 25px;
        }
        .text {
            font-size: 14px;
        }
        .table-1 {
            border-collapse: collapse;
        }
        .table-1 tr th, .table-1 tr td {
            border: 1px solid black;
            padding: 3px;
        }
        .table-1 tr th {
            text-align: center;
        }
        .table-user-assessment tr td{
            padding: 0 5px;
        }
    </style>
@endsection
<div class="col-md-12">
    <div align="right">
        <span class="tag-rahasia"><b>RAHASIA</b></span>
    </div>
    <div align="center">
        <h3><b>LAPORAN ASSESSMENT</b></h3>
        <img src="{{ URL::asset('images/logo-sasa.png') }}" width="13%">
		<br><br>
        <table class="table-user-assessment">
            <tr>
                <td>NAMA</td>
                <td >:</td>
                <td style="padding: 0 5px;"> {{ $result->nama }}</td>
            </tr>
            <tr>
                <td>TANGGAL TEST</td>
                <td>:</td>
                <td style="padding: 0 5px;" class="date"> - </td>
            </tr>
            <tr>
                <td>JABATAN</td>
                <td>:</td>
                <td style="padding: 0 5px;"> {{ $result->jabatan }}</td>
            </tr>
            <tr>
                <td>DEPARTEMEN/DIVISI</td>
                <td>:</td>
                <td style="padding: 0 5px;"> {{ $result->departement }} / {{ $result->divisi }}</td>
            </tr>
            <tr>
                <td>LOKASI/KLIEN</td>
                <td>:</td>
                <td style="padding: 0 5px;"> {{ $result->area }}</td>
            </tr>
        </table>
    </div>
    <br>
    <br>
    <h3><b>KARAKTER KEPRIBADIAN: {{ empty($assess_report->kode_dev) ? '-' : $assess_report->kode_dev }} / {{ empty($assess_report->tipe_dev) ? '-' : $assess_report->tipe_dev }}</b></h3>
    <div class="text">
        {!! empty($assess_report->devinisi) ? '<i>devinisi tidak ditemukan</i>' : $assess_report->devinisi !!}
    </div>
    <br><br>
    <table class="table-1" width="80%">
        <tr><td style="background-color: pink"><b>INDEKS KESESUAIAN TIPE PERSONALITAS</b></td></tr>
    </table>
    <table class="table-1" width="80%">
        <thead>
            <tr>
                <th width="50%" style="background-color: #ddd">KOMPETENSI</th>
                <th width="50%" style="background-color: #ddd">PRESENTASI KESESUAIAN</th>
            </tr>
        </thead>
        <tbody>
            @php
                $rata = 0;
            @endphp
            @foreach($data as $cat)
                @php
                    $rata += $cat['fit']
                @endphp
                <tr>
                    <td>{!! $cat['competency'] !!}</td>
                    <td align="center"><b>{!! $cat['fit'] !!}%</b></td>
                </tr>
            @endforeach
            @php
                if(count($data) == 0){
                    $total_rata = '0';
                } else {
                    $total_rata = round($rata/count($data));
                }
            @endphp
        </tbody>
        <thead>
            <tr>
                <th style="background-color: #eee">RATA-RATA</th>
                <th style="background-color: #eee">{!! $total_rata !!}%</th>
            </tr>
        </thead>
    </table>
    <br>
    <div><h4><b>Dari skala 100%, KESESUAIAN profil kompetensi dengan tipe personalitas ybs dengan tugas dan tanggungjawab jabatannya berada di angka {!! $total_rata !!}%, ({{strtoupper($assessmentresult->result)}})</b></h4></div>
    <br>
    <table class="table-1" width="80%">
        <tr><td style="background-color: pink"><b>SKALA REKOMENDASI HASIL TES</b></td></tr>
    </table>
    <table class="table-1" width="80%">
        <thead>
        <tr>
            <th style="background-color: #ddd">MIN(%)</th>
            <th style="background-color: #ddd">MAX(%)</th>
            <th style="background-color: #ddd">RESULT</th>
            <th style="background-color: #ddd">DESCRIPTION</th>
        </tr>
        </thead>
        <tbody>
        @foreach($quadran_result as $qr)
            <tr>
                <td align="center">{!! $qr->min !!}</td>
                <td align="center">{!! $qr->max !!}</td>
                <td>{!! $qr->result !!}</td>
                <td>{!! $qr->description !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@section('scripts')
    <script src="{{ URL::asset('plugins/moment/min/moment-with-locales.min.js')}}"></script>
    <script>
        $(function(){
            moment.lang("id")
            var date = moment('{{ date('m-d-Y', strtotime($result->last_test)) }}').format('LL');
            $('.date').html(date)
        })
    </script>
@endsection