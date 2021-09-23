<?php $user = App\Models\JwtSession::user() ?>
<nav class="bottom-navbar">
    <div class="container">
        <ul class="nav page-navigation" style="justify-content:inherit">
            <li class="nav-item">
                <a class="nav-link" href="{{url()->to('/')}}">
                <i class="ti-home menu-icon"></i>
                <span class="menu-title">Home</span>
                </a>
            </li>
            @if($user)
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)">
                <i class="ti-book menu-icon"></i>
                <span class="menu-title">Pengetahuan</span>
                <i class="menu-arrow"></i>
                </a>
                <div class="submenu">
                    <ul class="submenu-item">
                        <li class="nav-item"><a class="nav-link" href="{{route('pengetahuan.create')}}">Buat Pengetahuan</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{route('pengetahuan.index')}}">Pengetahuan Saya</a></li>
                        <!-- <li class="nav-item"><a class="nav-link" href="{{route('admin.notif.index')}}">Pengetahuan Berbintang</a></li> -->
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)">
                <i class="ti-stats-up menu-icon"></i>
                <span class="menu-title">Statistik</span>
                </a>
            </li>
            @if($user->role->role_id==1)
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)">
                <i class="ti-settings menu-icon"></i>
                <span class="menu-title">Pengaturan</span>
                <i class="menu-arrow"></i>
                </a>
                <div class="submenu">
                    <ul class="submenu-item">
                        <li class="nav-item"><a class="nav-link" href="{{route('admin.kategori.index')}}">Kategori Pengetahuan</a></li>
                        <!-- <li class="nav-item"><a class="nav-link" href="{{route('admin.notif.index')}}">Notifikasi</a></li> -->
                    </ul>
                </div>
            </li>
            @endif
            @endif
        </ul>
    </div>
</nav>