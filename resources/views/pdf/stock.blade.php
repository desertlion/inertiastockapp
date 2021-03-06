@extends('pdf')
@section('title')
Laporan Persediaan Barang Periode {{ $months[ltrim($bulan, '0') - 1] }} {{ $tahun }}
@endsection

@section('content')
    @include('pdf.header')
    <div class="container">
      <h1 class="mb-8 font-bold text-2xl text-center">
        Laporan Persediaan Barang<br>Periode {{ $months[ltrim($bulan,"0") - 1] }} {{ $tahun }}
      </h1>
      <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full whitespace-no-wrap border">
          <tr class="text-left font-bold">
            <th class="px-6 pt-6 pb-4 border">Nama Barang</th>
            <th class="px-6 pt-6 pb-4 border">Stock Awal</th>
            <th class="px-6 pt-6 pb-4 border">Masuk</th>
            <th class="px-6 pt-6 pb-4 border">Keluar</th>
            <th class="px-6 pt-6 pb-4 border">Stock Akhir</th>
          </tr>
          @foreach($reports as $report)
          <tr>
            <td class="border px-6 py-4">
                {{ $report->product_name }}
            </td>
            <td class="border px-6 py-4">
                {{ $report->jumlah_sebelum }}
            </td>
            <td class="border px-6 py-4">
                {{ $report->jumlah_masuk }}
            </td>
            <td class="border px-6 py-4">
                {{ $report->jumlah_keluar }}
            </td>
            <td class="border px-6 py-4">
                {{ $report->stock }}
            </td>
          </tr>
          @endforeach
          @if(count($reports) < 1)
          <tr>
            <td class="border-t px-6 py-4" colspan="4">No Data found.</td>
          </tr>
          @endif
        </table>
      </div>
    </div>
    @include('pdf.footer')
@endsection
