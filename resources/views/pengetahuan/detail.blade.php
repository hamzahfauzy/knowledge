@extends('layouts.app')

@section('content')
<?php $user = App\Models\JwtSession::user() ?>
<div class="row">
    <div class="col-12 col-sm-9">
        <div class="profile-feed">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="ms-4">
                        <h4 class="h4"><a href="{{route('detail',$post->slug)}}" class="text-decoration-none" title="{{$post->title}}">{{$post->title}}</a></h4>
                        <h6>
                        Oleh : {{$post->posted_by_name}}&nbsp;
                        <small class="ms-4 text-muted"><i class="ti-time mr-1"></i>{{$post->posted_date}}</small>
                        <span class="small text-muted mt-2 mb-0">
                        &nbsp;|
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
                        </span>
                        </h6>
                    </div>
                    <hr>
                    <div class="post-content">
                        {!! $post->content !!}
                    </div>
                </div>
            </div>

            @if($msg = Session::get('success'))
            <div class="alert alert-success mb-3" style="display:block;width:100%">
                {{$msg}}
            </div>
            @endif

            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="h4">Komentar</h4>

                    <form action="" method="post">
                        @csrf
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                        @if($user)
                        <input type="hidden" name="replied_by_id" value="{{$user->user_id}}">
                        @endif
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" name="replied_by" value="{{$user?$user->nama:''}}">
                        </div>
                        <div class="form-group">
                            <label for="">Isi Komentar</label>
                            <textarea class="form-control" id="summernoteExample" name="messages"></textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success">Kirim Komentar</button>
                        </div>
                    </form>
                </div>
            </div>

            @forelse($post->conversations()->orderby('id','desc')->get() as $conversation)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <img src="{{asset('images/profile.png')}}" alt="profile" class="img-sm rounded-circle mr-3">
                        <div class="ms-4">
                            <h6>{{$conversation->replied_by}}</h6>
                            <p><small class="ms-4 text-muted"><i class="ti-time mr-1"></i>{{$conversation->date}}</small></p>
                            <br>
                            <div class="post-content">
                                {!! $conversation->messages !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <center><i>Tidak ada komentar!</i></center>
            @endforelse
        </div>
    </div>
    <div class="col-12 col-lg-3">
        @include("partials.right-sidebar")
    </div>
</div>
@endsection