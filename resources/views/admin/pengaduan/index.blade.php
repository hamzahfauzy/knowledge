@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card mx-auto">
        <div class="card">
            <div class="card-header">
                Data Pengaduan - {{$filter}}
            </div>
            <div class="card-body">
                @if($msg = Session::get('success'))
                <div class="alert alert-success">
                    {{$msg}}
                </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-striped datatable">
                        <thead>
                        <tr>
                            <th>ID Pengaduan</th>
                            <th>Pelapor</th>
                            <th>Judul Pengaduan</th>
                            <th>Status</th>
                            <th>Update</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($pengaduans as $pengaduan)
                        <tr>
                            <td>{{$pengaduan->id_pengaduan}}</td>
                            <td>
                            <b>{!! $pengaduan->label_nama !!}</b>
                            <br>
                            <small>Tanggal Laporan : {{$pengaduan->created_at->format('Y-m-d H:i')}}</small>
                            </td>
                            <td>{{$pengaduan->judul}}</td>
                            <td>
                                {!!$pengaduan->status_label!!}
                            </td>
                            <td>{{$pengaduan->riwayat->created_at->format('Y-m-d H:i')}}</td>
                            <td>
                                @if($pengaduan->riwayat->status != 'Di Arsipkan')
                                <a href="{{route('admin.pengaduan.update-status',['pengaduan'=>$pengaduan->id,'status'=>'Di Arsipkan'])}}" class="btn btn-outline-danger">Arsipkan</a>
                                @endif
                                <a href="{{route('admin.pengaduan.show',$pengaduan->id)}}" class="btn btn-outline-primary">Detail</a>
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