<?php
use App\Models\Category;
$categories = Category::get();
?>
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
            <button class="btn btn-primary btn-block">Filter</button>
        </form>
    </div>
</div>
@section('script')
<script>
@if(isset($_GET['filter']['opd']) && !empty($_GET['filter']['opd']))
init_opds({!!json_encode([["opd_id"=>$_GET['filter']['opd']]])!!})
@else
get_opds(false)
@endif
</script>
@endsection