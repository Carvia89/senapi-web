<nav class="navbar header-navbar pcoded-header">
    <div class="navbar-wrapper">
        <div class="navbar-logo">
            <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="#!">
                <i class="ti-menu"></i>
            </a>
            <div class="mobile-search waves-effect waves-light">
                <div class="header-search">
                    <div class="main-search morphsearch-search">
                        <div class="input-group">
                            <span class="input-group-prepend search-close"><i class="ti-close input-group-text"></i></span>
                            <input type="text" class="form-control" placeholder="Enter Keyword">
                            <span class="input-group-append search-btn"><i class="ti-search input-group-text"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#">
                <img class="img-fluid" src="{{ asset('dappro_dash_assets/assets/images/Logo-p.png') }}" alt="Theme-Logo" />
            </a>
            <a class="mobile-options waves-effect waves-light">
                <i class="ti-more"></i>
            </a>
        </div>

        @php
            $user = auth()->user();
            $nom = $user->name;
            $prenom = $user->prenom;

            // Initialiser la variable photo
            $photo = asset('dappro_dash_assets/assets/images/user-profile_.jpg'); // Chemin par défaut si pas de photo

        @endphp

        <div class="navbar-container container-fluid">
            <ul class="nav-left">
                <li>
                    <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                </li>
                <li>
                    <a href="#!" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                        <i class="ti-fullscreen"></i>
                    </a>
                </li>
            </ul>
            <ul class="nav-right">
                <li class="header-notification">
                    <a href="#!" class="waves-effect waves-light">
                        <i class="ti-bell"></i>
                        <span class="badge bg-c-red"></span>
                    </a>
                </li>
                <li class="user-profile header-notification">
                    <a href="#!" class="waves-effect waves-light">
                        <img src="{{ $photo }}" class="img-radius" alt="User-Profile-Image">
                        <span>{{ $prenom }} {{ $nom }}</span>
                        <i class="ti-angle-down"></i>
                    </a>
                    <ul class="show-notification profile-notification">
                        <li class="waves-effect waves-light">
                            <a href="{{ route('admin.change.password') }}">
                                <i class="ti-settings"></i> Paramètres
                            </a>
                        </li>
                        <li class="waves-effect waves-light">
                            <a href="{{ route('admin.profile') }}">
                                <i class="ti-user"></i> Profile
                            </a>
                        </li>
                        <li class="waves-effect waves-light">
                            <a href="{{ route('logout') }}">
                                <i class="ti-layout-sidebar-left"></i> Se Déconnecter
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
