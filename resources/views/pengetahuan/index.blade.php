@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <span class="h5 mb-4 text-gray-800">Data Pengetahuan</span>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <a href="{{route('pengetahuan.create')}}" class="btn btn-sm btn-primary"><em class="ti-plus"></em> Buat Pengetahuan Baru</a>
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
                            <th>Kategori</th>
                            <th>Visibility</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($model as $key => $value)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>
                                <span>{{$value->title}}</span>
                                <div class="clearfix"></div>
                                <br>
                                <a href="{{route('pengetahuan.edit',$value->id)}}" title="Ubah">Ubah</a>
                                |
                                <a href="{{route('detail',$value->slug)}}" title="Lihat">Lihat</a>
                                |
                                <a href="{{route('pengetahuan.delete',$value->id)}}" title="Hapus" onclick="if(confirm('Hapus data ini ?')){return true}else{return false}">Hapus</a>
                            </td>
                            <td>
                                @forelse($value->categories as $key => $category)
                                <span>
                                    {{$category->title}}
                                    @if(isset($value->categories[$key+1]))
                                        ,
                                    @endif
                                </span>
                                @empty
                                <i>Tidak ada kategori</i>
                                @endforelse
                            </td>
                            <td>{{$value->visibility}}</td>
                            <td>{{$value->created_at}}</td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="5"><i>Tidak ada data</i></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </li>
    </ul>

</div>

@endsection