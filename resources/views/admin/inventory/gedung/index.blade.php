@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Inventory (Gedung)</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Data Gedung</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        {{-- Tombol Tambah Data --}}
        <a href="{{route('gedung.create')}}" class="btn btn-info btn-icon-text mb-2 mb-md-0 me-2">
            <i class="btn-icon-prepend" data-feather="plus"></i>
            Tambah Data
        </a>
        {{-- Tombol Export Excel --}}
        <a href="{{ route('gedung.export.excel', request()->query()) }}" class="btn btn-success btn-icon-text mb-2 mb-md-0 me-2">
            <i class="btn-icon-prepend" data-feather="file-text"></i>
            Export Excel
        </a>
        {{-- Tombol Export PDF --}}
        <a href="{{ route('gedung.export.pdf', request()->query()) }}" class="btn btn-danger btn-icon-text mb-2 mb-md-0">
            <i class="btn-icon-prepend" data-feather="file"></i>
            Export PDF
        </a>
    </div>
</div>

@include('components.alert')

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Filter Data Gedung</h6>
                {{-- FORM FILTER --}}
                <form action="{{ route('gedung.index') }}" method="GET">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label for="kd_up" class="form-label">Filter Berdasarkan Unit Pelaksana (UP)</label>
                                <select class="form-select select2" name="kd_up" id="kd_up">
                                    <option value="">-- Tampilkan Semua Unit --</option>
                                    @foreach ($regions as $region)
                                        <option value="{{ $region->kd_region }}" {{ request('kd_up') == $region->kd_region ? 'selected' : '' }}>
                                            {{ $region->nama_region }} ({{ $region->kd_region }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 align-self-end">
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('gedung.index') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <h6 class="card-title">Data Tabel Gedung</h6>
                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <!-- <th>Nama</th> -->
                                <th>Uraian</th>
                                <!-- <th>Alamat</th> -->
                                <th>UP</th>
                                <th>Unit</th>
                                <th>Pihak Pertama</th>
                                <th>Pihak Kedua</th>
                                <th>Alamat Kantor</th>
                                <th>Luas Tanah (m2)</th>
                                <th>Luas Bangunan (m2)</th>
                                <th>Asuransi Y/N</th>
                                <th>Status Sewa</th>
                                <th>No. Sertifikat</th>
                                <th>Nomor PJ</th>
                                <th>Tanggal Input</th>
                                <th>Periode Awal</th>
                                <th>Periode Akhir</th>
                                <th>Awal Sewa</th>
                                <th>Akhir Sewa</th>
                                <th>Tahun Sewa (Bulan)</th>
                                <th>Nilai</th>
                                <th>Keterangan</th>
                                <th>Validasi</th>
                                <th>BAST</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <!-- <td>{{ $data->nama }}</td> -->
                                    <td>{{ $data->uraian }}</td>
                                    <!-- <td>{{ $data->alamat }}</td> -->
                                    <td>{{ $data->region->nama_region ?? 'Tidak ada' }}</td>
                                    <td>{{ $data->unit_manual }}</td>
                                    <td>{{ $data->pihak_pertama }}</td>
                                    <td>{{ $data->pihak_kedua }}</td>
                                    <td>{{ $data->alamat_kantor }}</td>
                                    <td>{{ $data->luas_tanah_m2 }}</td>
                                    <td>{{ $data->luas_bangunan_m2 }}</td>
                                    <td>{{ $data->asuransi_yn }}</td>
                                    <td>{{ $data->status_sewa }}</td>
                                    <td>{{ $data->no_sertifikat }}</td>
                                    <td>{{ $data->nomor_pj }}</td>
                                    <td>{{ $data->tanggal_input ? \Carbon\Carbon::parse($data->tanggal_input)->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $data->periode_awal ? \Carbon\Carbon::parse($data->periode_awal)->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $data->periode_akhir ? \Carbon\Carbon::parse($data->periode_akhir)->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $data->awal_sewa ? \Carbon\Carbon::parse($data->awal_sewa)->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $data->akhir_sewa ? \Carbon\Carbon::parse($data->akhir_sewa)->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $data->tahun_sewa }}</td>
                                    <td>{{ number_format($data->nilai, 0, ',', '.') }}</td>
                                    <td>{{ $data->keterangan }}</td>
                                    <td>{{ $data->validasi }}</td>
                                    <td>
                                        @if(isset($data->bast))
                                            <a href="{{route('viewBastGedung',['id'=>$data->id])}}" class="btn btn-sm btn-success btn-icon">
                                                <i data-feather="eye"></i>
                                            </a>
                                        @else
                                            BAST tidak tersedia.
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('gedung.edit', ['gedung' => $data]) }}" class="btn btn-sm btn-primary btn-icon">
                                            <i data-feather="edit"></i>
                                        </a>
                                        <form action="{{ route('gedung.destroy', ['gedung'=> $data]) }}" style='display:inline;' method="POST" class="me-2">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger btn-icon" onclick="return confirm('Are you sure you want to delete this item?');">
                                                <i data-feather="trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
    <script>
        $(function() {
            'use strict';
            if ($(".select2").length) {
                $(".select2").select2();
            }
        });
    </script>
@endpush
