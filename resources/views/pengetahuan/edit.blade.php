@extends('layouts.app')

@section('content')
@if($msg = Session::get('success'))
<div class="alert alert-success">
    {{$msg}}
</div>
@endif
<form action="{{route('pengetahuan.update',$model->id)}}" method="POST">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-12">
            <h4>Edit Pengetahuan - {{$model->title}}</h4>
        </div>
        <div class="col-12 col-lg-9">
            <div class="form-group">
                <input type="text" name="title" class="form-control" id="judul" placeholder="Judul Pengetahuan" value="{{$model->title}}" required>
            </div>
            <div class="form-group">
                <textarea name="content" id="summernoteExample" required>{{$model->content}}</textarea>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card mb-2">
                <div class="card-header">
                    <span class="h5 mb-4 text-gray-800">Bagikan Kepada</span>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="visibility" id="optionsRadios1" value="internal" onchange="get_opds(this.value)" {{$model->visibility=='internal'?'checked=""':''}}>
                                Internal
                                <i class="input-helper"></i></label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="visibility" id="optionsRadios2" value="public" onchange="get_opds(this.value)" {{$model->visibility=='public'?'checked=""':''}}>
                                Publik
                                <i class="input-helper"></i></label>
                            </div>
                        </div>
                        <div class="opd {{$model->visibility == 'public' ? 'd-none' : '' }}">
                            <select name="opds[]" class="form-control opd_lists" multiple></select>
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
                        <select name="categories[]" class="select2 w-100" multiple data-placeholder="Pilih Kategori">
                            @foreach($categories as $category)
                            <option value="{{$category->id}}" {{in_array($category->id,$selected_categories)?'selected=""':''}}>{{$category->title}}</option>
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
                        <input name="tags" id="tags" value="{{$model->tags}}"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@if($model->visibility=='internal')
@section('script')
<script>
init_opds({!!json_encode($model->shares->toArray())!!})
</script>
@endsection
@endif