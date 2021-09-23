@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card mx-auto">
        <div class="card">
            <div class="card-header">
                Data Pengguna
            </div>
            <div class="card-body">
                @if($msg = Session::get('success'))
                <div class="alert alert-success">
                    {{$msg}}
                </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Nomor HP</th>
                                <th>Alamat</th>
                                <th>Jumlah Pengaduan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengadu as $key => $value)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$value->name}}</td>
                                <td>{{$value->email}}</td>
                                <td>{{$value->pengadus[0]->alamat}}</td>
                                <td>{{$value->pengadus()->count()}}</td>
                                <td>
                                    <a href="{{route('admin.pengguna.delete',$value->id)}}" class="btn btn-outline-danger" onclick="if(confirm('Hapus pengguna ini ?')){return true}else{return false}">Hapus</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6"><i>Tidak ada data</i></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection