@php
    $user = auth()->user();
    $nom = $user->name;
    $prenom = $user->prenom;

    // Initialiser la variable photo
    $photo = asset('dappro_dash_assets/assets/images/user-profile_.jpg'); // Chemin par défaut si pas de photo
    $userBureaux = [3, 9]; // ID des bureaux de la DAPPRO

    /*
    // Récupérer les informations selon le rôle de l'utilisateur
    if ($user->role === 'Elève') {
        $identity = App\Models\Eleve::find($user->user_reference_id); // Récupérer les informations de l'élève
        $photo = $identity->photo ? asset('storage/' . $identity->photo) : $photo;

    } elseif ($user->role === 'Enseignant') {
        $identity = App\Models\Enseignant::find($user->user_reference_id); // Récupérer les informations de l'enseignant
        $photo = $identity->photo ? asset('storage/' . $identity->photo) : $photo;

    } elseif ($user->role === 'Tuteur') {
                    $identity = App\Models\Tutaire::find($user->user_reference_id); // Récupérer les informations du tuteur
                    $photo = $identity->photo ? asset('storage/' . $identity->photo) : $photo;
    }
*/
@endphp

<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="">
            <div class="main-menu-header">
                <img class="img-80 img-radius" src="{{ $photo }}" alt="User-Profile-Image">
                <div class="user-details">
                    <span id="more-details">{{ $prenom }} {{ $nom }}<i class="fa fa-caret-down"></i></span>
                </div>
            </div>
            <div class="main-menu-content">
                <ul>
                    <li class="more-details">
                        <a href="#!"><i class="ti-user"></i>Voir Profil</a>
                        @if (auth()->user()->role == 'Admin')
                            <a href="#"><i class="ti-settings"></i>Paramètres</a>
                        @endif
                        <a href="{{ route('logout') }}"><i class="ti-layout-sidebar-left"></i>Se Déconnecter</a>
                    </li>
                </ul>
            </div>
        </div>


            <div class="p-15 p-b-0">
                <form class="form-material">
                    <div class="form-group form-primary">
                        <input type="text" name="footer-email" class="form-control">
                        <span class="form-bar"></span>
                        <label class="float-label"><i class="fa fa-search m-r-10"></i>Recherche</label>
                    </div>
                </form>
            </div>

        @if(auth()->user()->role == 'Admin')
            <ul class="pcoded-item pcoded-left-item">
                <li class="{{ request()->routeIs('dashboard.bureau') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.bureau') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-home"></i></span>
                        <span class="pcoded-mtext">Dashboard</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            </ul>
            <div class="pcoded-navigation-label">Scolarité</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="#">
                    <a href="#" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-calendar-alt"></i><b>C</b></span>
                        <span class="pcoded-mtext">Années Scolaires</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <ul class="pcoded-item pcoded-left-item">
                    <li class="pcoded-hasmenu {{ request()->routeIs('dashboard.bureau') ||
                            request()->routeIs('admin.fournisseur.*') ||
                            request()->routeIs('admin.direction.*') ? 'active' : '' }} pcoded-trigger">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                            <span class="pcoded-mtext">Niveaux Scolaires</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="{{ request()->routeIs('admin.bureau.*') ? 'active' : '' }}">
                                <a href="{{ route('admin.fournisseur.create') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Niveaux</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <li class="{{ request()->routeIs('admin.bureau.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.bureau.create') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-book"></i><b>C</b></span>
                        <span class="pcoded-mtext">Cours</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.division.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.division.create') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-calendar-alt"></i><b>M</b></span>
                        <span class="pcoded-mtext">Horaires de Cours</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            </ul>
            <div class="pcoded-navigation-label">Comptes Utilisateurs</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="pcoded-hasmenu {{ request()->routeIs('admin.division.*') ||
                    request()->routeIs('admin.division.*') ||
                    request()->routeIs('admin.divsion.*') ? 'active' : '' }} pcoded-trigger">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Gestion Utilisateurs</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('admin.bureau.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.bureau.create') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Enseignants</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin.bureau.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.bureau.create') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Elèves</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="pcoded-navigation-label">Rapport Effectif</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="{{ request()->routeIs('bureau.form') ? 'active' : '' }}">
                    <a href="{{ route('bureau.form') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-users"></i></span>
                        <span class="pcoded-mtext">Effectif des Elèves</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            </ul>
        @elseif (in_array($user->bureau_id, $userBureaux) && $user->role == 'User')
            <div class="pcoded-navigation-label">Bureau Fournitures</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="{{ request()->routeIs('admin.bureau.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.bureau.index') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-calculator"></i></span>
                        <span class="pcoded-mtext">Fournisseurs</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('dashboard.direction3') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.direction3') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-credit-card"></i></span>
                        <span class="pcoded-mtext">Stock Début </span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <ul class="pcoded-item pcoded-left-item">
                    <li class="pcoded-hasmenu {{ request()->routeIs('dashboard.direction3') ||
                            request()->routeIs('dashboard.direction3') ||
                            request()->routeIs('dashboard.direction3') ? 'active' : '' }} pcoded-trigger">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                            <span class="pcoded-mtext">Mouvement de Stock</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="{{ request()->routeIs('dashboard.direction1') ? 'active' : '' }}">
                                <a href="{{ route('dashboard.direction1') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Panier</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('dashboard.direction3') ? 'active' : '' }}">
                                <a href="{{ route('dashboard.direction3') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Approvisionnement</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('dashboard.direction3') ? 'active' : '' }}">
                                <a href="{{ route('dashboard.direction3') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Livraison</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="pcoded-item pcoded-left-item">
                    <li class="pcoded-hasmenu {{ request()->routeIs('dashboard.direction3') ||
                            request()->routeIs('dashboard.direction3') ||
                            request()->routeIs('dashboard.direction3') ? 'active' : '' }} pcoded-trigger">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                            <span class="pcoded-mtext">Promotion</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="{{ request()->routeIs('dashboard.direction1') ? 'active' : '' }}">
                                <a href="{{ route('dashboard.direction1') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Niveaux</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('dashboard.direction3') ? 'active' : '' }}">
                                <a href="{{ route('dashboard.direction3') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Options</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('dashboard.direction3') ? 'active' : '' }}">
                                <a href="{{ route('dashboard.direction3') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Classes</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="pcoded-item pcoded-left-item">
                    <li class="pcoded-hasmenu {{ request()->routeIs('dashboard.direction3') ||
                            request()->routeIs('dashboard.direction3') ||
                            request()->routeIs('dashboard.direction3') ? 'active' : '' }} pcoded-trigger">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                            <span class="pcoded-mtext">Reporting</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="{{ request()->routeIs('dashboard.direction1') ? 'active' : '' }}">
                                <a href="{{ route('dashboard.direction1') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Fiche de stock</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('dashboard.direction3') ? 'active' : '' }}">
                                <a href="{{ route('dashboard.direction3') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Sit. Gén. Bulletins</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('dashboard.direction3') ? 'active' : '' }}">
                                <a href="{{ route('dashboard.direction3') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Sit. Gén. Humanités</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </ul>
        @elseif(auth()->user()->role == 'Enseignant')
            <div class="pcoded-navigation-label">Espace Enseignant</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="{{ request()->routeIs('dashboard.direction3') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.direction3') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-book"></i><b>FC</b></span>
                        <span class="pcoded-mtext">Mes Cours</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('dashboard.direction1') ||
                            request()->routeIs('dashboard.direction1') ? 'active' : '' }}">
                    <a href="{{ route('dashboard.direction1') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-clock"></i><b>FC</b></span>
                        <span class="pcoded-mtext">Pointage Présences</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.bureau.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.bureau.create') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-file-alt"></i><b>FC</b></span>
                        <span class="pcoded-mtext">Transcription Côtes</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            </ul>
        @endif
    </div>
</nav>
