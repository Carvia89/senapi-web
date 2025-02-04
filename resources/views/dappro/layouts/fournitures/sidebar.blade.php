@php
    $user = auth()->user();
    $nom = $user->name;
    $prenom = $user->prenom;

    // Initialiser la variable photo
    $photo = asset('dappro_dash_assets/assets/images/user-profile_.jpg'); // Chemin par défaut si pas de photo
    $userBureaux = [3, 9]; // ID des bureaux de la DAPPRO
    $userBurVente = [10]; // ID des bureaux division Vente
    $userBurDistr = [11]; // ID des bureaux distribution

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

        <!-- *************** BUREAU MAGASINAGE FOURNITURES SCOLAIRES ******************* -->

        @elseif (in_array($user->bureau_id, $userBureaux) && $user->role == 'User')
            <div class="pcoded-navigation-label">Bureau Fournitures</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="{{ request()->routeIs('admin.fourn-founisseurs') ? 'active' : '' }}">
                    <a href="{{ route('admin.fourn-founisseurs') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-truck"></i></span>
                        <span class="pcoded-mtext">Fournisseurs</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.stockDebut-Fourniture.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.stockDebut-Fourniture.create') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-shopping-cart"></i></span>
                        <span class="pcoded-mtext">Stock Début </span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <ul class="pcoded-item pcoded-left-item">
                    <li class="pcoded-hasmenu {{ request()->routeIs('admin.entree-Fourniture.*') ||
                            request()->routeIs('admin.transfert-commande.*') ||
                            request()->routeIs('admin.inventaire') ||
                            request()->routeIs('admin.sortie-Fourniture.*') ? 'active' : '' }} pcoded-trigger">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                            <span class="pcoded-mtext">Mouvement de Stock</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="{{ request()->routeIs('admin.transfert-commande.*') ? 'active' : '' }}">
                                <a href="{{ route('admin.transfert-commande.index') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Commandes en attente</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('admin.entree-Fourniture.*') ? 'active' : '' }}">
                                <a href="{{ route('admin.entree-Fourniture.create') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Approvisionnement</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('admin.sortie-Fourniture.*') ? 'active' : '' }}">
                                <a href="{{ route('admin.sortie-Fourniture.create') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Livraison</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('admin.inventaire') ? 'active' : '' }}">
                                <a href="{{ route('admin.inventaire') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Inventaire</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="pcoded-item pcoded-left-item">
                    <li class="pcoded-hasmenu {{ request()->routeIs('admin.niveauxScol') ||
                            request()->routeIs('admin.cycleScol') ||
                            request()->routeIs('admin.optionBul') ||
                            request()->routeIs('admin.kelasi') ? 'active' : '' }} pcoded-trigger">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                            <span class="pcoded-mtext">Promotion</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="{{ request()->routeIs('admin.niveauxScol') ? 'active' : '' }}">
                                <a href="{{ route('admin.niveauxScol') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Niveaux</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('admin.cycleScol') ? 'active' : '' }}">
                                <a href="{{ route('admin.cycleScol') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Cycles</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('admin.optionBul') ? 'active' : '' }}">
                                <a href="{{ route('admin.optionBul') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Options</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('admin.kelasi') ? 'active' : '' }}">
                                <a href="{{ route('admin.kelasi') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Classes</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="pcoded-item pcoded-left-item">
                    <li class="pcoded-hasmenu {{ request()->routeIs('admin.situation.generale') ||
                            request()->routeIs('admin.sit.gen.bulScol') ||
                            request()->routeIs('admin.form.fiche.stock') ? 'active' : '' }} pcoded-trigger">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                            <span class="pcoded-mtext">Reporting</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="{{ request()->routeIs('admin.form.fiche.stock') ? 'active' : '' }}">
                                <a href="{{ route('admin.form.fiche.stock') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Fiche de stock</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('admin.sit.gen.bulScol') ? 'active' : '' }}">
                                <a href="{{ route('admin.sit.gen.bulScol') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Sit. Gén. Bulletins</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('admin.situation.generale') ? 'active' : '' }}">
                                <a href="{{ route('admin.situation.generale') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Sit. Gén. Humanités</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </ul>

        <!-- ************************* BUREAU POINT DE VENTE ************************** -->

        @elseif(in_array($user->bureau_id, $userBurVente) && $user->role == 'User')
            <div class="pcoded-navigation-label">Bureau Vente</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="{{ request()->routeIs('admin.client-Vente.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.client-Vente.create') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-users"></i><b>FC</b></span>
                        <span class="pcoded-mtext">Clients</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.stockDebut-Vente.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.stockDebut-Vente.create') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-shopping-cart"></i><b>SA</b></span>
                        <span class="pcoded-mtext">Stock Début</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="pcoded-hasmenu {{ request()->routeIs('admin.commande-Interne.*') ||
                    request()->routeIs('admin.commande-Externe.*') ||
                    request()->routeIs('dashboard.direction3') ? 'active' : '' }} pcoded-trigger">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Commandes</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('admin.commande-Interne.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.commande-Interne.create') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Interne</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin.commande-Externe.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.commande-Externe.create') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Externe</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ request()->routeIs('admin.appro-Vente.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.appro-Vente.create') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-cart-plus"></i><b>FC</b></span>
                        <span class="pcoded-mtext">Approvisionnement</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.livraison-Vente.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.livraison-Vente.create') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-truck"></i><b>LV</b></span>
                        <span class="pcoded-mtext">Livraison</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <ul class="pcoded-item pcoded-left-item">
                    <li class="pcoded-hasmenu {{ request()->routeIs('admin.form.ficheStk.vente') ||
                            request()->routeIs('admin.sit.gen.bulScol') ||
                            request()->routeIs('admin.form.fiche.stock') ? 'active' : '' }} pcoded-trigger">
                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                            <span class="pcoded-mtext">Reporting</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="{{ request()->routeIs('admin.form.ficheStk.vente') ? 'active' : '' }}">
                                <a href="{{ route('admin.form.ficheStk.vente') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Fiche de stock</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </ul>

        @elseif(in_array($user->bureau_id, $userBurVente) && $user->role == 'Caissier')
            <div class="pcoded-navigation-label">Bureau Vente</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="{{ request()->routeIs('admin.caisse-vente-Bulletins.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.caisse-vente-Bulletins.create') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-book"></i><b>FC</b></span>
                        <span class="pcoded-mtext">Facturation</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            </ul>

        <!-- ************************* BUREAU DISTRIBUTION ************************** -->

        @elseif(in_array($user->bureau_id, $userBurDistr) && $user->role == 'User')
            <div class="pcoded-navigation-label">Bureau Distribution</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="{{ request()->routeIs('admin.transfert-commande.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.transfert-commande.create') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-paper-plane"></i><b>FC</b></span>
                        <span class="pcoded-mtext">Transfert Commandes</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.colisage.liste') ? 'active' : '' }}">
                    <a href="{{ route('admin.colisage.liste') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-file-alt"></i><b>SA</b></span>
                        <span class="pcoded-mtext">Liste de Colisage</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.note.envoie') ? 'active' : '' }}">
                    <a href="{{ route('admin.note.envoie') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="fas fa-file-alt"></i><b>FC</b></span>
                        <span class="pcoded-mtext">Note d'Envoi</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            </ul>
        @endif
    </div>
</nav>
