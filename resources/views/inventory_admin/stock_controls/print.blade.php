<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Inventori Barang</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 20px;
        }

        /* Tabler title */
        .table-title {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .table-title,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            /* padding: 10px; */
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .table-title>td>img {
            display: block;
            margin: 0 auto;
        }

        .header-cell {
            text-align: center;
            vertical-align: middle;
        }

        /* Containter */
        .container {
            margin-top: 10px;
            /* border: 1px solid black; */
            height: 700px;
        }

        .flex-container {
            display: flex;
            padding: 10px 4%;
            justify-content: space-between;
        }

        .flex-container p {
            margin: 0;
        }

        .container>.table-data {
            width: 100%;
            border-collapse: collapse;
            /* margin: auto; */
        }

        .container>.table-data>thead>tr>th {
            background-color: #cdcdcd !important;
            /* padding: 10px; */
            font-weight: 500;
            text-align: center;
            font-size: 13px;
            vertical-align: middle;
            border: 1px solid black;
        }

        .container>.table-data>tbody>tr>td {
            padding: 4px;
            border: 1px solid black;
            font-size: 10px;
            text-align: center;
            height: 7px;
        }

        .table-signature {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table-signature>tbody>tr>td {
            border: none;
        }

        .page-break {
            page-break-after: always;
        }

        header {
            position: fixed;
            top: 0;
            left: 0px;
            right: 0px;
            height: 50px;
            text-align: center;
        }

        /* footer {
            position: absolute;
            bottom: 0;
            width: 100%;
        } */

        .page-num:before {
            content: counter(page);
        }
    </style>
</head>

<body>
    <header>
        <table class="table-title">
            <thead>
                <tr>
                    <td style="width: 100px; height: 90px; text-align: center; vertical-align: middle;">
                        <img src="{{ asset('assets/img/me/Logopotensiutama.png') }}" alt="Logo" width="85px"
                            style="text-align: center">
                    </td>
                    <td class="header-cell">
                        <strong>DOKUMEN LEVEL</strong><br>FORM
                    </td>
                    <td class="header-cell" style="width: 30%;">
                        <strong>NO. DOKUMEN</strong><br>F-INV-01-04
                    </td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="2" class="header-cell">
                        <strong>JUDUL</strong><br>STOCK CONTROL
                    </td>
                    <td class="" style="font-size:14px;">
                        <span style="width: 90px;"> Tanggal Terbit </span> : 05 Des 2016
                    </td>
                </tr>
                <tr>
                    <td class="" style="font-size:14px;">
                        <span style="=width: 90px;"> Tanggal Efektif </span> : 10 Des 2016
                    </td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="2" class="header-cell">
                        <strong>AREA</strong><br>INVENTORI
                    </td>
                    <td class="">
                        <div id="page-num-container" style="font-size:14px;">
                            <span style="width: 90px; ">Halaman</span> : <span
                                class="page-num"></span> dari <span class="page-count">{!! session('pageCount') !!}</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="header-cell">
                        <strong>NO. REVISI</strong><br>01
                    </td>
                </tr>
            </thead>
        </table>
    </header>
    @php
        $currentNumber = 1;
    @endphp
    @forelse ($chunkedData as $index => $dataChunk)
        <div class="container" style="position: absolute; bottom: 0; width: 100%; left: 0; top: 200px;">
            <div class="flex-container" style="display: flex; justify-content: space-between; font-size: 13px;">
                <div style="position: absolute;">
                    <p>Nama Barang : {{ $itemName }}</p>
                </div>
            </div>
            <table class="table-data" style="margin-top: 15px;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Masuk</th>
                        <th>Keluar</th>
                        <th>Sisa</th>
                        <th>Paraf</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataChunk as $item)
                        <tr>
                            <td>{{ $currentNumber++ }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                            <td style="text-align: left;">{{ $item->description }}</td>
                            <td>{{ $item->in }}</td>
                            <td>{{ $item->out }}</td>
                            <td>{{ $item->stock_after }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @empty
        <h4 style="text-align: center; margin-top: 250px;">Tidak ada data</h4>
    @endforelse

</body>

</html>
