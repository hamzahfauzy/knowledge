@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <span class="h5 mb-4 text-gray-800">Data Kategori</span>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">

            <a href="{{route('admin.kategori.create')}}" class="btn btn-sm btn-primary"><em class="ti-plus"></em> Buat Kategori Baru</a>
        </li>
        <li class="list-group-item">
            @if($msg = Session::get('success'))
            <div class="alert alert-success">
                {{$msg}}
            </div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover datatable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($model as $key => $value)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$value->title}}</td>
                            <td>
                                <a href="{{route('admin.kategori.edit',$value->id)}}" style="padding:6px; margin-top: -6px; margin-bottom: -6px;" class="btn btn-info" title="Ubah"><em class="ti-pencil"></em></a>
                                <a href="{{route('admin.kategori.delete',$value->id)}}" style="padding:6px; margin-top: -6px; margin-bottom: -6px;" class="btn btn-danger" title="Hapus" onclick="if(confirm('Hapus data ini ?')){return true}else{return false}"><em class="ti-trash"></em></a>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="3"><i>Tidak ada data</i></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </li>
    </ul>

</div>

@endsection