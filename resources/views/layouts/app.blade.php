<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title',config('app.name', 'WBS'))</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{asset('vendors/ti-icons/css/themify-icons.css')}}">
  <link rel="stylesheet" href="{{asset('vendors/css/vendor.bundle.base.css')}}">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="{{asset('vendors/summernote/dist/summernote-lite.css')}}">
  <link rel="stylesheet" href="{{asset('vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
  <link rel="stylesheet" href="{{asset('vendors/select2/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('vendors/jquery-tags-input/jquery.tagsinput.min.css')}}">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="https://layanan.labura.go.id/assets/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('images/logo.png')}}" />
  <style>
    table.dataTable td,
    table.dataTable th {
      -webkit-box-sizing: content-box;
      box-sizing: content-box;
      padding: 8px 10px;
    }

    .dataTables {
      box-sizing: border-box;
      display: inline-block;
      min-width: 1.5em;
      padding: 8px 10px;
      margin-top: 0;
      text-align: center;
      text-decoration: none !important;
      cursor: pointer;
      *cursor: hand;
      color: #333 !important;
      border: 0px solid transparent;
      border-top: 1px solid transparent;
      border-radius: 2px;
    }
    div.tagsinput {
      padding:8px;
      padding-left:15px;
    }
    .note-editable {
      background:#FFF;
    }
    .profile-feed img {
      max-width: 100% !important;
    }
    .post-content {
      font-size:14px;
    }
    .select2 {
      max-width:100%;
    }
  </style>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_horizontal-navbar.html -->
    <div class="horizontal-menu">
      @include('partials.top')

      @include('partials.nav')
    </div>

    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        @include('partials.footer')
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="{{asset('vendors/js/vendor.bundle.base.js')}}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- Plugin js for this page-->
  <script src="{{asset('vendors/datatables.net/jquery.dataTables.js')}}"></script>
  <script src="{{asset('vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
  <script src="{{asset('vendors/select2/select2.min.js')}}"></script>
  <script src="{{asset('vendors/jquery-tags-input/jquery.tagsinput.min.js')}}"></script>
  <script src="{{asset('vendors/summernote/dist/summernote-lite.min.js')}}"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{asset('js/off-canvas.js')}}"></script>
  <script src="{{asset('js/hoverable-collapse.js')}}"></script>
  <script src="{{asset('js/template.js')}}"></script>
  <script src="{{asset('js/settings.js')}}"></script>
  <script src="{{asset('js/todolist.js')}}"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="{{asset('js/dashboard.js')}}"></script>
  <script src="{{asset('js/todolist.js')}}"></script>
  <!-- End custom js for this page-->

  <script>
    $('.datatable').dataTable()
    $('.select2').select2({
      allowClear: true
    })
    $('#tags').tagsInput({
      'width': '100%',
      'height': '75%',
      'interactive': true,
      'defaultText': 'Tag',
      'removeWithBackspace': true,
      'minChars': 0,
      'maxChars': 20, // if not provided there is no limit
      'placeholderColor': '#666666'
    });
    if ($("#summernoteExample").length) {
      $('#summernoteExample').summernote({
        height: 300,
        tabsize: 2
      });
    }

    var opds = []
    async function get_opds(val)
    {
        if(val == 'public')
        {
            document.querySelector('.opd').classList.toggle('d-none')
            return
        }
        else
            document.querySelector('.opd').classList.toggle('d-none')
        var opd = []
        if(opds.length)
            opd = opds
        else
        {
            var formData = new FormData;
            formData.append('user_key','64240-d0ede73ccaf823f30d586a5ff9a35fa5')
            formData.append('pass_key','b546a6dfc4')
            var request = await fetch('https://layanan.labura.go.id/api/getSkpd',{
                method:'POST',
                body:formData
            })

            opd = await request.json()
        }

        var lists = ''
        for(i in opd)
        {
          var el = opd[i]
          lists += '<option value="'+el.id_skpd+'">'+el.nama_skpd+'</option>'
        }

        if(val == false)
          lists = '<option value="">- Pilih -</option>' + lists
        document.querySelector('.opd_lists').innerHTML = lists
        $('.opd_lists').select2({
          allowClear: true
        })
    }

    async function init_opds(opd_lists)
    {
      var ids = []
      for(j=0;j<opd_lists.length;j++)
        ids.push(opd_lists[j].opd_id)
      var formData = new FormData;
      formData.append('user_key','64240-d0ede73ccaf823f30d586a5ff9a35fa5')
      formData.append('pass_key','b546a6dfc4')
      var request = await fetch('https://layanan.labura.go.id/api/getSkpd',{
          method:'POST',
          body:formData
      })

      opd = await request.json()
      var lists = ''
      for(i in opd)
      {
        var el = opd[i]
        var selected = ids.includes(el.id_skpd) ? 'selected' : '';
        lists += '<option value="'+el.id_skpd+'" '+selected+'>'+el.nama_skpd+'</option>'
      }

      document.querySelector('.opd_lists').innerHTML = lists
      $('.opd_lists').select2({
        allowClear: true
      })
    }
  </script>

  @yield('script')
</body>

</html>