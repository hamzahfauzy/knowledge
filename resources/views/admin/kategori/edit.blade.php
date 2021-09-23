@extends('layouts.app')

@section('content')


<div class="card">
    <div class="card-header">
        <span class="h5 mb-4 text-gray-800">Ubah Data Kategori</span>
    </div>
    @if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
    @endif
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <a href="{{route('admin.kategori.index')}}" class="btn btn-danger btn-sm"><em class="ti-arrow-left"></em> Kembali</a>
        </li>
        <li class="list-group-item">
            <form action="{{route('admin.kategori.update', $category->id)}}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="" class="font-weight-bold">Judul <small class="text-danger">*</small></label>
                    <input type="text" class="form-control" value="{{$category->title}}" name="title" required placeholder="Judul Kategori">
                </div>
                <button class="btn btn-outline-primary">Simpan</button>
            </form>

        </li>
    </ul>
</div>


@endsection