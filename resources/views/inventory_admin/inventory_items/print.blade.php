<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Print Permohonan Pengembangan Koneksi Jaringan</title>
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

      .table-title > td > img {
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

      .container > .table-data {
         width: 100%;
         border-collapse: collapse;
         /* margin: auto; */
      }
      .container > .table-data > thead > tr > th{
         background-color: #cdcdcd !important;
         /* padding: 10px; */
         font-weight: 500;
         text-align: center;
         font-size: 13px;
         vertical-align: middle;
         border: 1px solid black;
      }
      .container > .table-data > tbody > tr > td {
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

      .table-signature > tbody > tr > td {
         border: none;
      }
      
      .page-break {
         page-break-after: always;
      }
      
      header {
         position: absolute;
         top: 0;
         left: 0px;
         right: 0px;
         height: 50px;
         text-align: center;
      }
      
      footer {
         position: absolute;
         bottom: 0;
         width: 100%;
      }
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
                  <img src="{{ asset('assets/img/me/Logopotensiutama.png') }}" alt="Logo" width="85px" style="text-align: center">
               </td>
               <td class="header-cell">
                  <strong>DOKUMEN LEVEL</strong><br>FORM
               </td>
               <td class="header-cell" style="width: 30%;">
                  <strong>NO. DOKUMEN</strong><br>F-/SPMI/06-04-05
               </td>
            </tr>
            <tr>
               <td colspan="2" rowspan="2" class="header-cell">
                  <strong>JUDUL</strong><br>DAFTAR INVENTARIS KESELURUHAN
               </td>
               <td class="">
                  <span style="width: 120px; display: inline-block"> Tanggal Terbit </span> : 08 April 2019
               </td>
            </tr>
            <tr>
               <td class="">
                  <span style="width: 120px; display: inline-block"> Tanggal Efektif </span> : 15 April 2019
               </td>
            </tr>
            <tr>
               <td colspan="2" rowspan="2" class="header-cell">
                  <strong>AREA</strong><br>BAGIAN INVENTORI
               </td>
               <td class="">
                  <div id="page-num-container">
                     <span style="width: 120px; display: inline-block">Halaman</span> : <span class="page-num"></span> dari <span class="page-count">{!! session('pageCount') !!}</span>
                 </div>
               </td>
            </tr>
            <tr>
               <td class="header-cell">
                  <strong>NO. REVISI</strong><br>00
               </td>
            </tr>
         </thead>
      </table>
   </header>
   @php
    $pageNumber = 1;
   @endphp
   @foreach ($chunkedData as $index => $dataChunk)
    <div class="container" style="position: absolute; bottom: 0; width: 100%; left: 0; {{ $index === 0 ? 'top: 200px;' : '' }}">
        <div class="flex-container" style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 500;">
            <div style="position: absolute; margin-bottom: 10px;">
                <p>Bulan: {{ $time->isoFormat('MMMM') }} {{ $time->isoFormat('YYYY') }}</p>
            </div>
        </div>
        <table class="table-data" style="margin-top: 15px;">
            <thead>
                <tr>
                    <th rowspan="2">No.</th>
                    <th rowspan="2">Tgl Pengadaan</th>
                    <th rowspan="2">Nama Inventaris</th>
                    <th rowspan="2">Merek</th>
                    <th rowspan="2">Spesifikasi</th>
                    <th rowspan="2">Jumlah</th>
                    <th rowspan="2">Kode Inventaris</th>
                    <th rowspan="2">Harga</th>
                    <th rowspan="2">Nama Supplier</th>
                    <th rowspan="2">Kapasitas PK</th>
                    <th colspan="3">Kondisi</th>
                    <th rowspan="2">Lokasi</th>
                    <th rowspan="2">Keterangan</th>
                </tr>
                <tr>
                    <th>B</th>
                    <th>KB</th>
                    <th>RB</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataChunk as $item)
                    <tr>
                        <td>{{ $pageNumber++ }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->date)->locale('id_ID')->isoFormat('D MMMM YYYY') }}</td>
                        <td style="text-align:left;">{{ $item->name }}</td>
                        <td>{{ $item->brand ?? '-' }}</td>
                        <td>{{ $item->spesification ?? '-' }}</td>
                        <td>{{ $item->stock }}</td>
                        <td>{{ $item->code ?? '-' }}</td>
                        <td>{{ $item->price ?? '-' }}</td>
                        <td>{{ $item->supplier_name ?? '-' }}</td>
                        <td>{{ $item->capacity_pk ?? '-'}}</td>
                        <td>
                            @if ($item->condition_id == 1)
                                <div style="font-family: DejaVu Sans, sans-serif;">
                                    &#10003;
                                </div>
                            @endif
                        </td>
                        <td>
                            @if ($item->condition_id == 2)
                                <div style="font-family: DejaVu Sans, sans-serif;">
                                    &#10003;
                                </div>
                            @endif
                        </td>
                        <td>
                            @if ($item->condition_id == 3)
                                <div style="font-family: DejaVu Sans, sans-serif;">
                                    &#10003;
                                </div>
                            @endif
                        </td>
                        <td>{{ $item->location ?? '-' }}</td>
                        <td>{{ $item->description ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if (!$loop->last)
        <div class="page-break"></div>
    @endif
@endforeach
   <footer>
      {{-- Signature Path --}}
      <div class="signature-path">
         <p style="margin: 4px 0;">Medan, {{ \Carbon\Carbon::now()->locale('id_ID')->isoFormat('D MMMM YYYY') }}</p>
         <table class="table-signature" >
             <tbody>
                 <tr>
                     <td style="text-align: left;">
                         Dibuat Oleh :
                     </td>
                     <td style="text-align: left;">
                         Diperiksa Oleh :
                     </td>
                     <td style="text-align: left;">
                         Disetujui Oleh :
                     </td>
                 </tr>
                 <tr>
                     <td style="text-align: left;">
                         Kabag Inventori
                     </td>
                     <td style="text-align: left;">
                         Kabag Umum
                     </td>
                     <td style="text-align: left;">
                         Wakil Rektor II
                     </td>
                 </tr>
                 <tr>
                     <td>
                         <img src="{{ asset('image/ttd/puskom.png') }}" alt="Tanda Tangan Puskom" width="60" style="display: block; text-align: left;">
                     </td>
                     <td>
                         <img src="{{ asset('image/ttd/kabag.png') }}" alt="Tanda Tangan Kabag" width="60">
                     </td>
                     <td>
                         <img src="{{ asset('image/ttd/wakil_rektor2.png') }}" alt="Tanda Tangan Wakil Rektor 2" width="60">
                     </td>
                 </tr>
                 <tr>
                  <td>
                     (Dani Manesah, M.Sn)
                  </td>
                  <td>
                     (Hardianto M.Kom)
                  </td>
                  <td>
                     (Daifiria, M.Kom)
                  </td>
                 </tr>
             </tbody>
         </table>
         <p style="position: fixed; font-size:12px; left:10%; margin:auto;"><i>Dokumen ini milik Universitas Potensi Utama, Dilarang memperbanyak atau menggunakan informasi didalamnya tanpa persetujuan Universitas Potensi Utama</i></p>
     </div>
   </footer>
</body>
</html>

