@php
    $user = auth()->user();
    $nom = $user->name;
    $prenom = $user->prenom;

    // Initialiser la variable photo
    $photo = asset('dappro_dash_assets/assets/images/user-profile_.jpg'); // Chemin par défaut si pas de photo
    $userBurEliq = [2]; // ID du bureau Engagement et Liquidation
    $userBurBP = [1];
    $userBurCaisse = [13];

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
                        <a href="#!"><i class="ti-settings"></i>Paramètres</a>
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

        <!-- ******************** BUREAU ENGAGEMENT ET LIQUIDATION ***************************** -->

        @if(in_array($user->bureau_id, $userBurEliq) && $user->role == 'User')

            <div class="pcoded-navigation-label">Bureau Engagement & Liquidation</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="{{ route('dashboard.bureau.eliq') }}">
                    <a href="{{ route('dashboard.bureau.eliq') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                        <span class="pcoded-mtext">Dashboard</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.banque-senapi.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.banque-senapi.index') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-bank"></i><b>C</b></span>
                        <span class="pcoded-mtext">Banques Associées</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.beneficiaire.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.beneficiaire.index') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-users"></i><b>C</b></span>
                        <span class="pcoded-mtext">Bénéficiaires</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.dossier.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.dossier.create') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-folder"></i><b>C</b></span>
                        <span class="pcoded-mtext">Dossier</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="pcoded-hasmenu {{ request()->routeIs('admin.numérisation-etat-de-besoin.*') ||
                    request()->routeIs('admin.bon-de-dépense-complète.*') ||
                    request()->routeIs('admin.bon-de-dépense-partielle.*') ? 'active' : '' }} pcoded-trigger">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Etat de sortie</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('admin.numérisation-etat-de-besoin.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.numérisation-etat-de-besoin.create') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Etat de Besoin</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin.bon-de-dépense-complète.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.bon-de-dépense-complète.create') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Bon de Dépense Complète</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin.bon-de-dépense-partielle.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.bon-de-dépense-partielle.create') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Bon de Dépense Partielle</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

        <!-- ******************** BUREAU BUDGET PROGRAMME ***************************** -->

        @elseif(in_array($user->bureau_id, $userBurBP) && $user->role == 'CB')
            <div class="pcoded-navigation-label">Bureau Budget Programme</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="{{ request()->routeIs('admin.imputation.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.imputation.index') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-code"></i><b>C</b></span>
                        <span class="pcoded-mtext">Nommenclature</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.imputation-bon-depense.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.imputation-bon-depense.index') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-table"></i><b>C</b></span>
                        <span class="pcoded-mtext">Bons à imputer</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            </ul>

        <!-- ******************** BUREAU CAISSE/COMPTABILITE ***************************** -->

        @elseif(in_array($user->bureau_id, $userBurCaisse) && $user->role == 'User')
            <div class="pcoded-navigation-label">Bureau Comptabilité / Caisse</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="{{ request()->routeIs('admin.mot-cle-imputation.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.mot-cle-imputation.create') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-code"></i><b>C</b></span>
                        <span class="pcoded-mtext">Mot clé d'imputation</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="pcoded-hasmenu {{ request()->routeIs('admin.numérisation-etat-de-besoin.*') ||
                    request()->routeIs('admin.bon-de-dépense-complète.*') ||
                    request()->routeIs('admin.bon-de-dépense-partielle.*') ? 'active' : '' }} pcoded-trigger">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Livret de Caisse</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('admin.numérisation-etat-de-besoin.*') ? 'active' : '' }}">
                            <a href="#" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Recettes</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin.bon-de-dépense-complète.*') ? 'active' : '' }}">
                            <a href="#" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Dépenses</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin.bon-de-dépense-partielle.*') ? 'active' : '' }}">
                            <a href="#" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Autres Dépenses</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="pcoded-hasmenu {{ request()->routeIs('admin.numérisation-etat-de-besoin.*') ||
                    request()->routeIs('admin.bon-de-dépense-complète.*') ||
                    request()->routeIs('admin.bon-de-dépense-partielle.*') ? 'active' : '' }} pcoded-trigger">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Reporting</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('admin.numérisation-etat-de-besoin.*') ? 'active' : '' }}">
                            <a href="#" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Rapport Financier</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin.bon-de-dépense-complète.*') ? 'active' : '' }}">
                            <a href="#" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Rapport Dépenses</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin.bon-de-dépense-partielle.*') ? 'active' : '' }}">
                            <a href="#" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Rapport Recettes</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>

        @endif
    </div>
</nav>
