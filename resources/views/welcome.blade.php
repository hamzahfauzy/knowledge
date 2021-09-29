@extends('layouts.app')

@section('content')
<?php $user = App\Models\JwtSession::user() ?>
@if($user)
<div class="row">
    <div class="col-12 mb-3">
        <div class="card">
            <div class="card-header">
                <span class="h5 mb-4 text-gray-800">Sistem Informasi Manajemen Pengetahuan Kab. Labuhanbatu Utara</span>
            </div>
            <div class="card-body">
                Hai, <b>{{$user->nama}}</b>. Selamat Datang di Sistem Informasi Manajemen Pengetahuan Kab. Labuhanbatu Utara
            </div>
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-12 mb-3">
        <form action="" class="position-relative">
            @if(isset($_GET['page']))
            <input type="hidden" name="page" value="{{$_GET['page']}}">
            @endif
            <button class="border-0 rounded-0 position-absolute h-100 pl-3" style="background:transparent;"><i class="ti-search"></i></button>
            <input type="text" name="keyword" id="" class="form-control rounded-0" placeholder="Cari Pengetahuan ..." style="height:auto;padding-left:40px;">
        </form>
    </div>
    <div class="col-12 col-lg-9">
        <div class="profile-feed">
            @forelse($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <img src="{{asset('images/profile.png')}}" alt="profile" class="img-sm rounded-circle mr-3">
                        <div class="ms-4">
                            <h6>
                            <a href="{{route('detail',$post->slug)}}" title="{{$post->title}}">{{$post->title}}</a>
                            <small class="ms-4 text-muted"><i class="ti-time mr-1"></i>{{$post->posted_date}}</small>
                            </h6>
                            <p class="small text-muted mt-2 mb-0">
                            <span>Oleh : {{$post->posted_by_name}}</span> | 
                            @forelse($post->categories as $key => $category)
                            <span>
                                {{$category->title}}
                                @if(isset($post->categories[$key+1]))
                                    ,
                                @endif
                            </span>
                            @empty
                            <i>Tidak ada kategori</i> 
                            @endforelse
                            &nbsp; | &nbsp;
                            Tag : {!!$post->tags??'<i>Tidak ada tag</i>'!!}
                            &nbsp; | &nbsp;
                            <a href="{{route('detail',$post->slug)}}" class="text-decoration-none" title="{{$post->title}}">
                                <span class="mr-1 ms-2">
                                    <i class="ti-comment mr-1"></i>{{$post->conversations()->count()}}
                                </span>
                            </a>
                            @if($user->role->role_id == 1 || $user->user_id == $post->posted_by_id)
                            &nbsp; | &nbsp;
                            <a href="{{route('pengetahuan.edit',$post->id)}}" class="text-decoration-none">
                            <span class="mr-1">
                                <i class="ti-pencil mr-1"></i> Ubah
                            </span>
                            </a>
                            &nbsp; | &nbsp;
                            <a href="{{route('pengetahuan.delete',$post->id)}}" class="text-decoration-none" onclick="if(confirm('Hapus data ini ?')){return true}else{return false}">
                            <span class="mr-1">
                                <i class="ti-trash mr-1"></i> Hapus
                            </span>
                            </a>
                            @endif
                            {{--
                            <a href="javascript:void(0)" class="text-decoration-none">
                            <span class="mr-1">
                                <i class="ti-star mr-1"></i>{{$post->stars()->count()}}
                            </span>
                            </a>
                            <span class="ms-2">
                                <i class="ti-share"></i>
                            </span>
                            --}}
                            </p>
                            <br>
                            <div class="post-content">
                                {!! \Illuminate\Support\Str::limit(strip_tags($post->content), 200, ' - <a href="'.route('detail',$post->slug).'">Selengkapnya</a>') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <center><i>Tidak ada data!</i></center>
            @endforelse

            {{$posts->links('vendor.pagination.bootstrap-4')}}
        </div>
    </div>
    <div class="col-12 col-lg-3">
        <div class="card">
            <div class="card-header">
                <span class="h5 mb-4 text-gray-800">Filter</span>
            </div>
            <div class="card-body">
                <form action="">
                    <div class="form-group">
                        <label for="">OPD</label>
                        <div class="opd {{ isset($_GET['filter']['opd']) && !empty($_GET['filter']['opd']) ? '' : 'd-none' }}">
                            <select name="filter[opd]" class="form-control opd_lists" data-placeholder="Pilih OPD"></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Kategori</label>
                        <div>
                            <select name="filter[category]" class="select2 w-100" data-placeholder="Pilih Kategori">
                                <option value="">- Pilih -</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" {{isset($_GET['filter']['category']) && $_GET['filter']['category'] == $category->id ? 'selected=""' : ''}}>{{$category->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Tag</label>
                        <div>
                            @forelse($tags as $tag)
                            <a href="?filter[tag]={{$tag}}" class="badge badge-success" style="border-radius:6px;">{{$tag}}</a>
                            @empty
                            <i>Tidak ada tag</i>
                            @endforelse
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block">Filter</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
@if(isset($_GET['filter']['opd']) && !empty($_GET['filter']['opd']))
init_opds({!!json_encode([["opd_id"=>$_GET['filter']['opd']]])!!})
@else
get_opds(false)
@endif
</script>
@endsection