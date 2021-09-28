@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
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
        </div>
    </div>
</div>
@endsection