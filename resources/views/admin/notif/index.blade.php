@extends('layouts.app')

@section('content')
<form action="" method="POST">
@csrf
<div class="row">
    <div class="col-12">
        @if($msg = Session::get('success'))
        <div class="alert alert-success">
            {{$msg}}
        </div>
        @endif
    </div>
    <div class="col-12 grid-margin stretch-card mx-auto">
        <div class="card">
            <div class="card-header">
                Field Tersedia
            </div>
            <div class="card-body">
                <code>[nama]</code>
                <code>[nomor_hp]</code>
                <code>[judul]</code>
                <code>[deskripsi]</code>
            </div>
        </div>
    </div>
    
    <div class="col-12 grid-margin stretch-card mx-auto">
        <div class="card">
            <div class="card-header">
                Notifikasi Pengguna
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">Pengetahuan Baru</label>
                    <textarea name="user[pengetahuan_baru]" class="form-control" required>{{count($notif)?$notif[0]->template_text:''}}</textarea>
                </div>

                <div class="form-group">
                    <label for="">Komentar</label>
                    <textarea name="user[komentar]" class="form-control" required>{{count($notif)?$notif[1]->template_text:''}}</textarea>
                </div>
            </div>
        </div>
    </div>
    {{--
    <div class="col-12 grid-margin stretch-card mx-auto">
        <div class="card">
            <div class="card-header">
                Notifikasi Admin
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">Pengaduan Masuk</label>
                    <textarea name="admin[pengaduan_masuk]" class="form-control" required>{{count($notif)?$notif[5]->template_text:''}}</textarea>
                </div>

                <div class="form-group">
                    <label for="">Chat Baru</label>
                    <textarea name="admin[chat_baru]" class="form-control" required>{{count($notif)?$notif[6]->template_text:''}}</textarea>
                </div>

            </div>
        </div>
    </div>
    --}}
    <div class="col-12">
        <button class="btn btn-success">Submit</button>
    </div>
</div>
</form>
@endsection