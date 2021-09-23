@extends('layouts.app')

@section('content')
<style>
.table th, .jsgrid .jsgrid-table th, .table td, .jsgrid .jsgrid-table td {
    padding: 3px 0px;
}
.overlay {
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1030;
    display: none;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    color:#FFF;
}
</style>
<div class="overlay">
    <h2>Mengirim Pengaduan...</h2>
</div>
<div class="row">
    <div class="col-12 col-lg-8 grid-margin stretch-card mx-auto">
        <div class="card">
            <div class="card-body">
                <h3 class="text-center">Form Pengaduan</h3>
                @if ($errors->any())
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                    </ul>
                @endif
                <form action="{{route('guest.store')}}" method="post" enctype="multipart/form-data" onsubmit="document.querySelector('.overlay').style.display='flex'">
                    @csrf
                    <div class="form-group">
                        <label for="" class="font-weight-bold">Nama <small class="text-danger">*</small></label>
                        <input type="text" class="form-control" name="nama" required placeholder="Nama Pengadu">
                    </div>
                    <div class="form-group">
                        <label for="" class="font-weight-bold">Alamat <small class="text-danger">*</small></label>
                        <textarea class="form-control" name="alamat" required placeholder="Alamat Pengadu"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="" class="font-weight-bold">Judul Pengaduan <small class="text-danger">*</small></label>
                        <input type="text" class="form-control" name="judul" required placeholder="Judul Pengaduan">
                    </div>
                    <div class="form-group">
                        <label for="" class="font-weight-bold">Uraian Pengaduan <small class="text-danger">*</small></label>
                        <textarea class="form-control" style="resize:auto;" name="deskripsi" required placeholder="Masukkan uraian pengaduan secara lengkap dan rinci"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="" class="font-weight-bold">Pihak yang Diduga Terlibat</label>
                        @include('guest.pihak')
                    </div>
                    <div class="form-group">
                        <label for="" class="font-weight-bold">Lampiran</label>
                        @include('guest.lampiran')
                    </div>
                    <div class="form-group">
                        <label for="" class="font-weight-bold">Rahasiakan Identitas Saya</label>
                        <br>
                        <label for="privasi_ya">
                        <input type="radio" name="privasi" id="privasi_ya" value="Ya"> Ya
                        </label>

                        <label for="privasi_tidak" class="ml-3">
                        <input type="radio" name="privasi" id="privasi_tidak" value="Tidak" checked> Tidak
                        </label>
                    </div>
                    {{--
                    <div class="form-group">
                        <label for="" class="font-weight-bold">Syarat dan Ketentuan</label>
                        <p>Sebelum mengirim pengaduan ini, mohon diingat bahwa hanya pengaduan yang memenuhi kriteria yang akan diproses lebih lanjut dan kami mengharapkan keseriusan pengaduan dengan melampirkan data pendukung yang memadai. Dengan klik Kirim, berarti anda telah setuju pada syarat dan ketentuan yang berlaku pada KPK Whistleblower System</p>
                    </div>
                    --}}
                    <button class="btn btn-success btn-block">Kirim</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection