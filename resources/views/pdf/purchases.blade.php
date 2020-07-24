@extends('pdf')
@section('title')
Laporan Pembelian Periode {{ $months[ltrim($bulan, '0') - 1] }} {{ $tahun }}
@endsection

@section('content')
    @include('pdf.header')
    <div class="container">
      <h1 class="mb-8 font-bold text-2xl text-center">
        Laporan Pembelian<br>Periode {{ $months[ltrim($bulan,"0") - 1] }} {{ $tahun }}
      </h1>
      <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full whitespace-no-wrap border">
          <tr class="text-left font-bold">
            <th class="px-6 pt-6 pb-4">Nama Barang</th>
            <th class="px-6 pt-6 pb-4">Nama Toko</th>
            <th class="px-6 pt-6 pb-4">Jumlah</th>
            <th class="px-6 pt-6 pb-4">Total Harga</th>
          </tr>
          @foreach($purchases as $report)
          <tr>
            <td class="border px-6 py-4">
                {{ $report->product->name }}
            </td>
            <td class="border px-6 py-4">
                {{ $report->nama_toko }}
            </td>
            <td class="border px-6 py-4">
                {{ $report->jumlah }}
            </td>
            <td class="border px-6 py-4">
                {{ $report->total_harga }}
            </td>
          </tr>
          @endforeach
          @if(count($purchases) < 1)
          <tr>
            <td class="border-t px-6 py-4" colspan="4">No Data found.</td>
          </tr>
          @endif
        </table>
      </div>
    </div>
    @include('pdf.footer')
@endsection
