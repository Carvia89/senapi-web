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
            <a href="#" id="dashboard-link">
                <img class="img-fluid" src="{{ asset('dappro_dash_assets/assets/images/Logo-p.png') }}" alt="Theme-Logo" />
            </a>
            <a class="mobile-options waves-effect waves-light">
                <i class="ti-more"></i>
            </a>
        </div>

        <script>
            document.getElementById('dashboard-link').addEventListener('click', function(event) {
                event.preventDefault(); // Empêche le comportement par défaut du lien

                // Vérifiez le rôle de l'utilisateur
                var userRole = "{{ auth()->user()->role }}"; // Récupère le rôle de l'utilisateur depuis le backend

                if (userRole === 'Admin' || userRole === 'Financier') {
                    window.location.href = "{{ route('dashboard.bureau') }}"; // Redirige vers le dashboard
                }
            });
        </script>
        <div class="navbar-container container-fluid">

            @php
                $user = auth()->user();
                $nom = $user->name;
                $prenom = $user->prenom;

                // Initialiser la variable photo
                $photo = asset('dappro_dash_assets/assets/images/user-profile_.jpg'); // Chemin par défaut si pas de photo
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
                @if (auth()->user()->role == 'User')
                <li class="header-notification">
                    <a href="#!" class="waves-effect waves-light">
                        <i class="ti-bell"></i>
                        <span class="badge bg-c-red"></span>
                    </a>
                    <style>
                        .notification {
                            padding: 10px;
                            border: 1px solid #ddd;
                            margin: 10px 0;
                        }
                    </style>
                    <ul class="show-notification">
                        <li>
                            <h6>Notifications</h6>
                            <label class="label label-danger">New</label>
                        </li>
                        <li class="waves-effect waves-light">
                            <div class="media">
                                <img class="d-flex align-self-center img-radius"
                                    src="{{ asset('dappro_dash_assets/assets/images/user-profile_.jpg') }}"
                                    alt="Generic placeholder image">
                                <div class="media-body">
                                    <h5 class="notification-user">Charles Thamba</h5>
                                    <p class="notification-msg">Les notifications seront bientôt prises en charge.</p>
                                    <span class="notification-time" id="session-time">0 minutes ago</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <script>
                        // Vérifier si l'heure de début est déjà enregistrée
                        let startTime = localStorage.getItem('sessionStartTime');

                        if (!startTime) {
                            startTime = Date.now(); // Enregistrer l'heure de début si elle n'existe pas
                            localStorage.setItem('sessionStartTime', startTime);
                        } else {
                            startTime = parseInt(startTime); // Convertir en entier
                        }

                        const sessionTimeDisplay = document.getElementById('session-time');

                        function updateSessionTime() {
                            const elapsedTime = Math.floor((Date.now() - startTime) / 60000); // Temps écoulé en minutes
                            sessionTimeDisplay.textContent = `${elapsedTime} minute${elapsedTime !== 1 ? 's' : ''} ago`; // Mettre à jour le texte
                        }

                        setInterval(updateSessionTime, 60000); // Mettre à jour toutes les minutes
                        updateSessionTime(); // Mettre à jour immédiatement au chargement
                    </script>
                </li>
                @endif
                <li class="user-profile header-notification">
                    <a href="#!" class="waves-effect waves-light">
                        <img src="{{ $photo }}" class="img-radius" alt="User-Profile-Image">
                        <span>{{ $prenom }} {{ $nom }}</span>
                        <i class="ti-angle-down"></i>
                    </a>
                    <ul class="show-notification profile-notification">
                        <li class="waves-effect waves-light">
                            <a href="">
                                <i class="ti-user"></i> Voir Profile
                            </a>
                        </li>
                        @if (auth()->user()->role == 'Admin')
                            <li class="waves-effect waves-light">
                                <a href="{{ route('taux.create') }}">
                                    <i class="ti-settings"></i> Paramètres
                                </a>
                            </li>
                        @endif
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
