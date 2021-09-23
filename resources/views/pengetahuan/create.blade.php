@extends('layouts.app')

@section('content')
<form action="{{route('pengetahuan.store')}}" method="POST">
    @csrf
    <div class="row">
        <div class="col-12">
            <h4>Buat Pengetahuan</h4>
        </div>
        <div class="col-12 col-md-9">
            <div class="form-group">
                <input type="text" name="title" class="form-control" id="judul" placeholder="Judul Pengetahuan" required>
            </div>
            <div class="form-group">
                <textarea name="content" id="summernoteExample" required></textarea>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card mb-2">
                <div class="card-header">
                    <span class="h5 mb-4 text-gray-800">Bagikan Kepada</span>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="visibility" id="optionsRadios1" value="internal">
                                Internal
                                <i class="input-helper"></i></label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="visibility" id="optionsRadios2" value="public" checked="">
                                Publik
                                <i class="input-helper"></i></label>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block">Publish</button>
                </div>
            </div>
            <div class="card mb-2">
                <div class="card-header">
                    <span class="h5 mb-4 text-gray-800">Kategori</span>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <select name="categories[]" class="select2 w-100" multiple  data-placeholder="Pilih Kategori">
                            @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="card mb-2">
                <div class="card-header">
                    <span class="h5 mb-4 text-gray-800">Tag</span>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <input name="tags" id="tags" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection