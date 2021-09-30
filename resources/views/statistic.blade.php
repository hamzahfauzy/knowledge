@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <div class="card">
            <div class="card-header">
                <span class="h5 mb-4 text-gray-800">Filter</span>
            </div>
            <div class="card-body">
                <form action="" style="display:flex;">
                    <div class="form-group">
                        <label for="">Tahun</label>
                        <select name="filter[tahun]" class="form-control select2" data-placeholder="Pilih Tahun" required>
                            <option value="">Semua</option>
                            @for($i=date('Y');$i>2000;$i--)
                            <option value="{{$i}}" {{isset($_GET['filter']['tahun']) && $_GET['filter']['tahun'] == $i ? 'selected=""' : ''}}>{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    &nbsp;
                    <div class="form-group">
                        <label for="">Bulan</label>
                        <select name="filter[bulan]" class="select2 w-100" data-placeholder="Pilih Bulan" required>
                            <option value="">Semua</option>
                            @for($i=1;$i<=12;$i++)
                            <option value="{{$i}}" {{isset($_GET['filter']['bulan']) && $_GET['filter']['bulan'] == $i ? 'selected=""' : ''}}>{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    &nbsp;
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        <button class="btn btn-primary btn-block">Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <span class="h5 mb-4 text-gray-800">Statistik</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>#</th>
                            <th>Author</th>
                            <th>Jumlah</th>
                        </tr>
                        @forelse($posts as $key => $post)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$post->posted_by_name}}</td>
                            <td><a href="{{url()->to('/')}}?filter[user]={{$post->posted_by_id}}">{{$post->jumlah}}</a></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3"><i>Tidak ada data !</i></td>
                        </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection