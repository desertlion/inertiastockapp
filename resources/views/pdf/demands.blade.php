@extends('pdf')
@section('title')
Laporan Permintaan Barang Periode {{ $months[ltrim($bulan, '0') - 1] }} {{ $tahun }}
@endsection

@section('content')
    @include('pdf.header')
    <div class="container">
      <h1 class="mb-8 font-bold text-2xl text-center">
        Laporan Permintaan Barang<br>Periode {{ $months[ltrim($bulan,"0") - 1] }} {{ $tahun }}
      </h1>
      <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full whitespace-no-wrap border">
          <tr class="text-left font-bold">
            <th class="px-6 pt-6 pb-4">Nama Barang</th>
            <th class="px-6 pt-6 pb-4">Pegawai</th>
            <th class="px-6 pt-6 pb-4">Jumlah</th>
            <th class="px-6 pt-6 pb-4">Tanggal Permintaan</th>
            <th class="px-6 pt-6 pb-4">Status</th>
          </tr>
          @foreach($demands as $report)
          <tr>
            <td class="border px-6 py-4">
                {{ $report->product->name }}
            </td>
            <td class="border px-6 py-4">
                {{ $report->pegawai->name }}
            </td>
            <td class="border px-6 py-4">
                {{ $report->jumlah }}
            </td>
            <td class="border px-6 py-4">
                {{ $report->tanggal_permintaan }}
            </td>
            <td class="border px-6 py-4">
              {{ $report->status > 0 ? 'Done' : 'Processing' }}
            </td>
          </tr>
          @endforeach
          @if(count($demands) < 1)
          <tr>
            <td class="border-t px-6 py-4" colspan="4">No Data found.</td>
          </tr>
          @endif
        </table>
      </div>
    </div>
    @include('pdf.footer')
@endsection
