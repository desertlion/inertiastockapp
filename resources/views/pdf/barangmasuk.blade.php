@extends('pdf')
@section('title')
Laporan Barang Masuk Periode {{ $months[ltrim($bulan, '0') - 1] }} {{ $tahun }}
@endsection

@section('content')
    <div class="container">
        @include('pdf.header')
      <h1 class="mb-8 font-bold text-2xl text-center">
        Laporan Barang Masuk<br>Periode {{ $months[ltrim($bulan,"0") - 1] }} {{ $tahun }}
      </h1>
      <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full whitespace-no-wrap border">
          <tr class="text-left font-bold">
            <th class="px-6 pt-6 pb-4 border">Nama Barang</th>
            <th class="px-6 pt-6 pb-4 border">Jumlah</th>
            <th class="px-6 pt-6 pb-4 border">Nama Toko</th>
            <th class="px-6 pt-6 pb-4 border">Penerima</th>
          </tr>
          @foreach($wares as $report)
          <tr>
            <td class="border px-6 py-4">
                {{ $report->product->name }}
            </td>
            <td class="border px-6 py-4">
                {{ $report->jumlah }}
            </td>
            <td class="border px-6 py-4">
                {{ $report->nama_toko }}
            </td>
            <td class="border px-6 py-4">
                {{ $report->Penerima->name }}
            </td>
          </tr>
          @endforeach
          @if(count($wares) < 1)
          <tr>
            <td class="border-t px-6 py-4" colspan="4">No Data found.</td>
          </tr>
          @endif
        </table>
      </div>
      @include('pdf.footer')
    </div>
@endsection
