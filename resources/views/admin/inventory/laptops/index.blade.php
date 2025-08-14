@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Inventory (Laptop)</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Data Laptop</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <a href="{{route('laptops.create')}}" class="btn btn-info btn-icon-text mb-2 mb-md-0 me-2">
            <i class="btn-icon-prepend" data-feather="plus"></i>
            Tambah Data
        </a>
        {{-- Tombol Export sekarang menyertakan parameter filter dari URL --}}
        <a href="{{ route('laptops.export.excel', request()->query()) }}" class="btn btn-success btn-icon-text mb-2 mb-md-0 me-2">
            <i class="btn-icon-prepend" data-feather="file-text"></i>
            Export Excel
        </a>
        <a href="{{ route('laptops.export.pdf', request()->query()) }}" class="btn btn-danger btn-icon-text mb-2 mb-md-0 me-2">
            <i class="btn-icon-prepend" data-feather="file"></i>
            Export PDF
        </a>
        <a href="{{ route('laptops.barcode.all.pdf', request()->query()) }}" class="btn btn-warning btn-icon-text mb-2 mb-md-0">
            <i class="btn-icon-prepend" data-feather="barcode"></i>
            Download Semua Barcode
        </a>
    </div>
</div>

@include('components.alert')

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Filter Data Laptop</h6>
                {{-- FORM UNTUK FILTER --}}
                <form action="{{ route('laptops.index') }}" method="GET">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label for="kd_region" class="form-label">Kantor Induk</label>
                                {{-- 1. Ubah 'name' dan 'id' menjadi 'kd_region' --}}
                                <select class="form-select select2" name="kd_region" id="kd_region">
                                    <option value="">-- Tampilkan Semua --</option>
                                    @foreach ($regions as $region)
                                        {{-- 2. Gunakan $region->kd_region sebagai 'value' --}}
                                        {{-- 3. Cek request('kd_region') untuk 'selected' --}}
                                        <option value="{{ $region->kd_region }}" {{ request('kd_region') == $region->kd_region ? 'selected' : '' }}>
                                            {{ $region->nama_region }} ({{ $region->kd_region }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 align-self-end">
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('laptops.index') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <h6 class="card-title">Data Laptop</h6>
                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Brand</th>
                                <th>Laptop Name</th>
                                <th>Spesification</th>
                                <th>User</th>
                                <th>Serial Number</th>
                                <th>IP Address</th>
                                <th>Kantor Induk</th>
                                <th>Status Asset</th>
                                <th>Vendor</th>
                                <th>Year</th>
                                <th>Bast</th>
                                <th>Generate</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->getDeviceBrands?->name ?? 'Tidak ada' }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->spesification }}</td>
                                    <td>{{ $data->user_name }}</td>
                                    <td>{{ $data->serial_number }}</td>
                                    <td>{{ $data->ip_address }}</td>
                                    <td>{{ $data->region->nama_region ?? 'Tidak ada' }}</td>
                                    <td>{{ $data->ownership_status }}</td>
                                    <td>{{ $data->vendor }}</td>
                                    <td>{{ $data->year }}</td>
                                    <td>
                                        @if(isset($data->bast))
                                            <a href="/viewBastLaptop/{{ $data->id }}" class="btn btn-sm btn-success btn-icon">
                                                <i data-feather="eye"></i>
                                            </a>
                                        @else
                                            BAST tidak tersedia.
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="generateDropdown{{ $data->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                    <polyline points="7,10 12,15 17,10"></polyline>
                                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="generateDropdown{{ $data->id }}">
                                                <li><a class="dropdown-item" href="#">
                                                    <svg class="me-2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                        <polyline points="14,2 14,8 20,8"></polyline>
                                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                                        <polyline points="10,9 9,9 8,9"></polyline>
                                                    </svg>
                                                    BAST
                                                </a></li>
                                                <li><a class="dropdown-item" href="#">
                                                    <svg class="me-2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                        <polyline points="14,2 14,8 20,8"></polyline>
                                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                                        <polyline points="10,9 9,9 8,9"></polyline>
                                                    </svg>
                                                    BASTB
                                                </a></li>
                                                <li><a class="dropdown-item" href="{{ route('laptops.barcode.pdf', $data->id) }}">
                                                    <svg class="me-2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M3 4h18"></path>
                                                        <path d="M3 8h18"></path>
                                                        <path d="M3 12h18"></path>
                                                        <path d="M3 16h18"></path>
                                                        <path d="M3 20h18"></path>
                                                    </svg>
                                                    Barcode PDF
                                                </a></li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('laptops.edit', ['laptop' => $data]) }}" class="btn btn-sm btn-primary btn-icon">
                                            <i data-feather="edit"></i>
                                        </a>
                                        <form action="{{ route('laptops.destroy', ['laptop'=> $data]) }}" style='display:inline;'  method="POST"  class="me-2" style="cursor:pointer;">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger btn-icon">
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
        
        // Re-initialize setelah DataTable selesai loading
        $(document).ready(function() {
            // Tambahkan callback untuk DataTable
            if ($.fn.DataTable) {
                $.fn.dataTable.ext.errMode = 'none';
            }
        });
    </script>
@endpush
