@extends('layouts.app')

@section('content')
<?php $user = App\Models\JwtSession::user() ?>
@if($user)
<div class="row">
    <div class="col-12 col-md-8 mx-auto mb-3">
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
    <div class="col-12 col-md-8 mx-auto mb-3">
        <form action="" class="position-relative">
            @if(isset($_GET['page']))
            <input type="hidden" name="page" value="{{$_GET['page']}}">
            @endif
            <button class="border-0 rounded-0 position-absolute h-100 pl-3" style="background:transparent;"><i class="ti-search"></i></button>
            <input type="text" name="keyword" id="" class="form-control rounded-0" placeholder="Cari Pengetahuan ..." style="height:auto;padding-left:40px;">
        </form>
    </div>
    <div class="col-12 col-md-8 mx-auto">
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
                            {!! \Illuminate\Support\Str::limit(strip_tags($post->content), 50, ' - <a href="'.route('detail',$post->slug).'">Selengkapnya</a>') !!}
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
</div>
@endsection