<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent text-sm" data-widget="treeview" role="menu"
        data-accordion="false">
        @if (auth()->user()->role == 'admin' or auth()->user()->role == 'verifikator')
            <li class="nav-item">
                <a href="{{ url('/dashboard') }}" class="nav-link   {{ request()->is('dashboard') ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-laptop-house text-white"></i>
                    <p class="text-white">
                        Dashboard
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/instansi') . '/' . $instansi->name }}" class="nav-link ">
                    <i class="nav-icon fab fa-chrome text-white"></i>
                    <p class="text-white ">
                        Website
                    </p>
                </a>
            </li>


            <li class="nav-item menu-open">
                <a href="#"
                    class="nav-link {{ request()->is('profil') ? 'active' : '' }}  {{ request()->is('statistik') ? 'active' : '' }}">
                    <p>
                        Entry Data
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/profil') }}" class="nav-link {{ request()->is('profil') ? 'active' : '' }}">
                            <i class="fas fa-camera-retro"></i>
                            <p>Profil Instansi </p>
                        </a>
                    </li>
                    @if (auth()->user()->role == 'admin' or auth()->user()->role == 'verifikator')
                        <li class="nav-item ">
                            <a href="{{ url('/statistik') }}"
                                class="nav-link {{ request()->is('statistik') ? 'active' : '' }}">
                                <i class=" fas fa-table"></i>
                                <p> Data statistik

                                    <div class=" d-flex right">
                                        @if ($nav['jumlah_note'] > 0)
                                            <span class="badge badge-warning">{{ $nav['jumlah_note'] }}</span>
                                        @endif
                                        @if ($nav['jumlah_validasi_ulang'] > 0)
                                            <span class="badge badge-info ">{{ $nav['jumlah_validasi_ulang'] }}</span>
                                        @endif
                                        @if ($nav['jumlah_validasi'] > 0)
                                            <span class="badge badge-danger ">{{ $nav['jumlah_validasi'] }}</span>
                                        @endif
                                    </div>
                                </p>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
        @if (auth()->user()->role == 'administrator' or auth()->user()->role == 'verifikator')
            <li class="nav-item menu-open">
                <a href="#"
                    class="nav-link {{ request()->is('statistik') ? 'active' : '' }}  {{ request()->is('verifikasi') ? 'active' : '' }}  {{ request()->is('visualisasi_data') ? 'active' : '' }}
                    {{ request()->is('data_instansi') ? 'active' : '' }} {{ request()->is('data_instansi/*') ? 'active' : '' }}">
                    <p>
                        @if (auth()->user()->role == 'administrator')
                            Menu Wali Data
                        @elseif (auth()->user()->role == 'verifikator')
                            Menu Verifikator
                        @endif
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @if (auth()->user()->role == 'administrator')
                        <li class="nav-item ">
                            <a href="{{ url('/statistik') }}"
                                class="nav-link {{ request()->is('statistik') ? 'active' : '' }}">
                                <i class=" fas fa-table"></i>
                                <p> Data statistik </p>
                            </a>
                        </li>
                    @endif


                    <li class="nav-item">
                        <a href="/verifikasi" class="nav-link {{ request()->is('verifikasi') ? 'active' : '' }}">
                            <i class="fas fa-copy"></i>
                            <p>
                                @if (auth()->user()->role == 'administrator')
                                    Validasi Data
                                    <span class="badge badge-danger right">{{ $nav['jumlah_validasi_all'] }}</span>
                                @elseif (auth()->user()->role == 'verifikator')
                                    Varifikasi Data
                                    <span class="badge badge-danger right">{{ $nav['jumlah_validasi_all'] }}</span>
                                @endif
                            </p>
                        </a>
                    </li>
                    @if (auth()->user()->role == 'administrator')
                        <li class="nav-item">
                            <a href="{{ url('/visualisasi_data') }}"
                                class="nav-link  {{ request()->is('visualisasi_data') ? 'active' : '' }}">
                                <i class="fas fa-chart-pie"></i>
                                <p>
                                    Visualisasi Data
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/data_publikasi') }}"
                                class="nav-link  {{ request()->is('data_publikasi') ? 'active' : '' }}">
                                <i class="far fa-folder-open"></i>
                                <p>
                                    Publikasi Data
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/data_instansi') }}"
                                class="nav-link {{ request()->is('data_instansi') ? 'active' : '' }}">
                                <i class="fas fa-laptop-house"></i>
                                <p>
                                    Data Instansi
                                </p>
                            </a>
                        </li>
                    @elseif (auth()->user()->role == 'verifikator')
                        <li class="nav-item">
                            <a href="{{ url('data_instansi/daftar_user/' . auth()->user()->instansi->name) }}"
                                class="nav-link {{ request()->is('data_instansi/*') ? 'active' : '' }}">
                                <i class="fas fa-users"></i>
                                <p>
                                    Data User
                                </p>
                            </a>
                        </li>
                    @endif

                </ul>
            </li>
        @endif
        @if (auth()->user()->role == 'administrator')
            <li class="nav-item menu-open">
                <a href="#"
                    class="nav-link {{ request()->is('statistik') ? 'active' : '' }}  {{ request()->is('verifikasi') ? 'active' : '' }}  {{ request()->is('visualisasi_data') ? 'active' : '' }}
                    {{ request()->is('data_instansi') ? 'active' : '' }} {{ request()->is('data_instansi/*') ? 'active' : '' }}">
                    <p>
                        Master Data
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @if (auth()->user()->role == 'administrator')
                        <li class="nav-item ">
                            <a href="{{ url('/indikator') }}"
                                class="nav-link {{ request()->is('indikator') ? 'active' : '' }}">
                                <i class=" fas fa-table"></i>
                                <p> Indikator IKU dan IKD </p>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
        <li class="nav-item menu-open">
            <a href="#" class="nav-link ">
                <p>
                    User
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ url('/logout') }}" class="nav-link">
                        <i class="fas fa-sign-out-alt"> </i>
                        <p>Logout</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.password.edit') }}" class="nav-link">
                        <i class="fas fa-key"></i>
                        <p>Ganti Password</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
