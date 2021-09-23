@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Data Riwayat Pengaduan
            </div>
            <div class="card-body">
                @if($msg = Session::get('success'))
                <div class="alert alert-success">
                    {{$msg}}
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped datatable">
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
                            @forelse($pengadus as $pengadu)
                            <tr>
                                <td>{{$pengadu->pengaduan->id_pengaduan}}</td>
                                <td>
                                    <b>{{$pengadu->nama}}</b>
                                    <br>
                                    <small>Tanggal Laporan : {{$pengadu->pengaduan->created_at->format('Y-m-d H:i')}}</small>
                                </td>
                                <td>{{$pengadu->pengaduan->judul}}</td>
                                <td>
                                    {!!$pengadu->pengaduan->status_label!!}
                                </td>
                                <td>{{$pengadu->pengaduan->riwayat->created_at->format('Y-m-d H:i')}}</td>
                                <td>
                                    <a href="{{route('guest.show',$pengadu->pengaduan_id)}}" style="padding:6px; margin-top: -6px; margin-bottom: -6px;" class="btn btn-outline-primary">Detail</a>
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