@php
    function month($month){
        $m = array('01' => 'Januari',
                   '02' => 'Februari',
                   '03' => 'Maret',
                   '04' => 'April',
                   '05' => 'Mei',
                   '06' => 'Juni',
                   '07' => 'Juli',
                   '08' => 'Agustus',
                   '09' => 'September',
                   '10' => 'Oktober',
                   '11' => 'November',
                   '12' => 'Desember');

        return $m[$month];
    }
@endphp

<style>
    body {
        font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;
        font-size: 12px;
    }
    .tag-rahasia {
        color: #000;
        background-color: #92d050;
        padding: 4px 25px;
        width: 90px;
        float: right;
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
<div class="col-md-12">
    <div align="right">
        <div class="tag-rahasia" align="center"><b>RAHASIA</b></div>
    </div>
    <br>
    <div align="center">
        <h3><b>LAPORAN ASSESSMENT</b></h3>
		<br><br>
        <img src="{{ URL::asset('images/philips-400px.png') }}" width="13%">
		<br><br>
        <table class="table-user-assessment" align="center">
            <tr>
                <td>NAMA</td>
                <td >:</td>
                <td style="padding: 0 5px;"> {{ $result->nama }}</td>
            </tr>
            <tr>
                <td>TANGGAL TEST</td>
                <td>:</td>
                <td style="padding: 0 5px;" class="date"> {{ date('d', strtotime($result->last_test)) }} {{ month(date('m', strtotime($result->last_test))) }} {{ date('Y', strtotime($result->last_test)) }} </td>
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
    {{--<h3><b>DESKRIPSI KEPRIBADIAN: </b></h3>--}}
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
            {{--@foreach($category_competency as $cat)--}}
                {{--<tr>--}}
                    {{--<td>{!! $cat->category_name !!}</td>--}}
                    {{--<td>{!! $cat->description !!}</td>--}}
                {{--</tr>--}}
            {{--@endforeach--}}
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
            <!--<th style="background-color: #eee">RATA-RATA</th>
            <th style="background-color: #eee">{!! $total_rata !!}%</th>-->
			<th style="border-top: solid 1px"></th>
            <th style="border-top: solid 1px"></th>
        </tr>
        </thead>
    </table>
    <br>
    {{--<div><h4><b>Dari skala 100%, KESESUAIAN profil kompetensi dengan tipe personalitas ybs dengan tugas dan tanggungjawab jabatannya berada di angka <span style="font-size: 17px; background-color: #92d050; padding: 3px">{!! $fit_score !!}%</span></b></h4></div>--}}
    <div><h4><b>Dari skala 100%, KESESUAIAN profil kompetensi dengan tipe personalitas ybs dengan tugas dan tanggungjawab jabatannya berada di angka {!! $total_rata !!}%, ({{strtoupper($assessmentresult->result)}})</b></h4></div>
    <br>
    <table class="table-1" width="80%">
        <tbody>
            <tr>
                <td style="background-color: pink"><b>SKALA REKOMENDASI HASIL TES</b></td>
            </tr>
        </tbody>
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
            {{--<tr>--}}
                {{--<td align="center">0</td>--}}
                {{--<td align="center">20</td>--}}
                {{--<td>Reject</td>--}}
                {{--<td>Tidak sesuai antara tipe kepribadian dengan pekerjaan</td>--}}
            {{--</tr>--}}
                    {{--<tr>--}}
                {{--<td align="center">21</td>--}}
                {{--<td align="center">40</td>--}}
                {{--<td>Tidak disarankan</td>--}}
                {{--<td>Kurang sesuai antara tipe kepribadian dengan pekerjaan</td>--}}
            {{--</tr>--}}
                    {{--<tr>--}}
                {{--<td align="center">41</td>--}}
                {{--<td align="center">60</td>--}}
                {{--<td>Dipertimbangkan</td>--}}
                {{--<td>Cukup sesuai antara tipe kepribadian dengan pekerjaan</td>--}}
            {{--</tr>--}}
                    {{--<tr>--}}
                {{--<td align="center">61</td>--}}
                {{--<td align="center">80</td>--}}
                {{--<td>Disarankan</td>--}}
                {{--<td>Sesuai antara tipe kepribadian dengan pekerjaan</td>--}}
            {{--</tr>--}}
                    {{--<tr>--}}
                {{--<td align="center">81</td>--}}
                {{--<td align="center">100</td>--}}
                {{--<td>Sangat disarankan</td>--}}
                {{--<td>Sangat sesuai antara tipe kepribadian dengan pekerjaan</td>--}}
            {{--</tr>--}}
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