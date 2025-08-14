@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Inventory (motor Dinas)</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Data motor Dinas</h4>
    </div>
<div class="d-flex align-items-center flex-wrap text-nowrap">
    <a href="{{route('motor-dinas.create')}}" class="btn btn-info btn-icon-text mb-2 mb-md-0 me-2">
        <i class="btn-icon-prepend" data-feather="plus"></i>
        Tambah Data
    </a>
    <a href="{{ route('motor-dinas.export.excel', request()->query()) }}" class="btn btn-success btn-icon-text mb-2 mb-md-0 me-2">
        <i class="btn-icon-prepend" data-feather="file-text"></i>
        Export Excel
    </a>
    <a href="{{ route('motor-dinas.export.pdf', request()->query()) }}" class="btn btn-danger btn-icon-text mb-2 mb-md-0">
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
                <h6 class="card-title">Filter Data Motor Dinas</h6>
                <form action="{{ route('motor-dinas.index') }}" method="GET">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label for="kd_region" class="form-label">Kantor Induk</label>
                                <select class="form-select select2" name="kd_region" id="kd_region">
                                    <option value="">-- Tampilkan Semua --</option>
                                    @foreach ($regions as $region)
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
                                <a href="{{ route('motor-dinas.index') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <h6 class="card-title">Data motor Dinas</h6>
                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Brand</th>
                                <th>Model</th>
                                <th>Nomor Polisi</th>
                                <th>Nomor Rangka</th>
                                <th>Nomor Mesin</th>
                                <th>Tahun Pembuatan</th>
                                <th>Warna</th>
                                <th>unit</th>
                                <th>Status Asset</th>
                                <th>Bast</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->brand->name }}</td>
                                    <td>{{ $data->model }}</td>
                                    <td>{{ $data->nomor_polisi }}</td>
                                    <td>{{ $data->nomor_rangka }}</td>
                                    <td>{{ $data->nomor_mesin }}</td>
                                    <td>{{ $data->tahun_pembuatan }}</td>
                                    <td>{{ $data->warna }}</td>
                                    <td>{{ $data->region->nama_region ?? 'Tidak ada' }}</td>
                                    <td>{{ $data->status_asset }}</td>
                                    <td>
                                        @if(isset($data->bast))
                                            <a href="{{route('viewBastMotorDinas',['id'=>$data->id])}}" class="btn btn-sm btn-success btn-icon">
                                                <i data-feather="eye"></i>
                                            </a>
                                        @else
                                            BAST tidak tersedia.
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('motor-dinas.edit', ['motor_dina' => $data]) }}" class="btn btn-sm btn-primary btn-icon">
                                            <i data-feather="edit"></i>
                                        </a>
                                        <form action="{{ route('motor-dinas.destroy', ['motor_dina'=> $data]) }}" style='display:inline;'  method="POST"  class="me-2" style="cursor:pointer;">
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
