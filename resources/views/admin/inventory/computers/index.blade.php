@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Inventory (Komputer)</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Data Komputer</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <a href="{{route('computers.create')}}" class="btn btn-info btn-icon-text mb-2 mb-md-0 me-2">
            <i class="btn-icon-prepend" data-feather="plus"></i>
            Tambah Data
        </a>
        {{-- Tombol Export sekarang menyertakan parameter filter dari URL --}}
        <a href="{{ route('computers.export.excel', request()->query()) }}" class="btn btn-success btn-icon-text mb-2 mb-md-0 me-2">
            <i class="btn-icon-prepend" data-feather="file-text"></i>
            Export Excel
        </a>
        <a href="{{ route('computers.export.pdf', request()->query()) }}" class="btn btn-danger btn-icon-text mb-2 mb-md-0">
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
                <h6 class="card-title">Filter Data Komputer</h6>
                {{-- FORM UNTUK FILTER --}}
                <form action="{{ route('computers.index') }}" method="GET">
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
                                <a href="{{ route('computers.index') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <h6 class="card-title">Data Komputer</h6>
                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Brand</th>
                                <th>Komputer Name</th>
                                <th>Spesification</th>
                                <th>User</th>
                                <th>Serial Number</th>
                                <th>IP Address</th>
                                <th>Kantor Induk</th>
                                <th>Asset Status</th>
                                <th>Vendor</th>
                                <th>Year</th>
                                <th>System Operation</th>
                                <th>Office</th>
                                <th>Status Join Domain</th>
                                <th>kes</th>
                                <th>Mouse</th>
                                <th>Keyboard</th>
                                <th>Monitor</th>
                                <th>Contract Date</th>
                                <th>Rental Price</th>
                                <th>Bast</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->getDeviceBrands->name }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->spesification }}</td>
                                    <td>{{ $data->user_name }}</td>
                                    <td>{{ $data->serial_number }}</td>
                                    <td>{{ $data->ip_address }}</td>
                                    <td>{{ $data->region->nama_region ?? 'Tidak ada' }}</td>
                                    <td>{{ $data->ownership_status }}</td>
                                    <td>{{ $data->getVendor->bp_name ?? 'Tidak ada' }}</td>
                                    <td>{{ $data->year }}</td>
                                    <td>{{ $data->system_operation }}</td>
                                    <td>{{ $data->office }}</td>
                                    <td>{!! $data->status_id == 1 ? 'ya' : 'tidak' !!}</td>
                                    <td>{{ $data->kes }}</td>
                                    <td>{{ $data->mouse }}</td>
                                    <td>{{ $data->keyboard }}</td>
                                    <td>{{ $data->monitor }}</td>
                                    <td>{{ $data->contract_date }}</td>
                                    <td>{{ $data->rental_price }}</td>
                                    <td>
                                        @if(isset($data->bast))
                                            <a href="/viewBastKomputer/{{ $data->id }}" class="btn btn-sm btn-success btn-icon">
                                                <i data-feather="eye"></i>
                                            </a>
                                        @else
                                            BAST tidak tersedia.
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('computers.edit', ['computer' => $data]) }}" class="btn btn-sm btn-primary btn-icon">
                                            <i data-feather="edit"></i>
                                        </a>
                                        <form action="{{ route('computers.destroy', ['computer'=> $data]) }}" style='display:inline;'  method="POST"  class="me-2" style="cursor:pointer;">
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
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
@endpush
