@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Master Data (Kategori Gangguan Jaringan)</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Data Kategori Gangguan Jaringan</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">   
            <a href="{{route('networkinterference.create')}}" class="btn btn-info btn-icon-text mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="plus"></i>
                Tambah Data
            </a>
        </div>
    </div>
    @include('components.alert')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Data Kategori Gangguan Jaringan</h6>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>No</th> 
                                    <th>Nama</th> 
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td> 
                                        <td>{{ $data->name }}</td> 
                                        <td>
                                            <a href="{{route('networkinterference.edit', ['networkinterference'=> $data])}}" class="btn btn-sm btn-primary btn-icon">
                                                <i data-feather="edit"></i>
                                            </a>
                                            <form action="{{ route('networkinterference.destroy', ['networkinterference'=>$data]) }}" style='display:inline;'  method="POST"  class="me-2" style="cursor:pointer;">
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
