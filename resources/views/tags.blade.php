@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <span class="h5 mb-4 text-gray-800">Tag</span>
            </div>
            <div class="card-body">
                <div>
                    @forelse($tags as $tag)
                    <a href="{{url()->to('/')}}?filter[tag]={{$tag['tag']}}" class="badge badge-success" style="border-radius:6px;margin-bottom:6px;">{{$tag['label']}}</a>
                    @empty
                    <i>Tidak ada tag</i>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection