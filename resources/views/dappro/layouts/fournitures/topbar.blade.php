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
                var userBureau = "{{ auth()->user()->bureau_id }}"; // Récupère le bureau de l'utilisateur depuis le backend

                if (userRole === 'User') {
                    if (userBureau == 10) {
                        window.location.href = "{{ route('dashboard.bureau.vente') }}"; // Redirige vers le bureau de vente
                    } else if (userBureau == 6) {
                        window.location.href = "{{ route('dashboard.bureau') }}"; // Redirige vers le bureau par défaut
                    } else if (userBureau == 9) {
                        window.location.href = "{{ route('dashboard.bureau') }}"; // Redirige vers le bureau par défaut
                    }
                } else if (userRole === 'Admin') {
                    window.location.href = "{{ route('dashboard.bureau') }}"; // Redirige vers le dashboard admin
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
                        <a href="#!" class="waves-effect waves-light" onclick="loadNotifications()">
                            <i class="ti-bell"></i>
                            <span class="badge bg-c-red" id="notification-count">{{ auth()->user()->unreadNotifications->count() }}</span>
                        </a>
                        <ul class="show-notification" id="notification-list">
                            <li>
                                <h6>Notifications</h6>
                                <label class="label label-danger">New</label>
                            </li>
                            <!-- Les notifications seront ajoutées ici -->
                        </ul>
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
                                <a href="#">
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
            <script>
                function loadNotifications() {
                    fetch('/notifications') // Endpoint pour récupérer les notifications
                        .then(response => response.json())
                        .then(data => {
                            const notificationList = document.getElementById('notification-list');
                            notificationList.innerHTML = ''; // Vider la liste des notifications
                            data.notifications.forEach(notification => {
                                const li = document.createElement('li');
                                li.className = 'waves-effect waves-light';
                                li.innerHTML = `
                                    <div class="media">
                                        <div class="media-body">
                                            <h5 class="notification-user">${notification.data.userName}</h5>
                                            <p class="notification-msg">${notification.data.message}</p>
                                            <a href="${notification.data.pdfPath}" download>Télécharger le PDF</a>
                                            <span class="notification-time">${notification.created_at}</span>
                                        </div>
                                    </div>
                                `;
                                notificationList.appendChild(li);
                            });
                            document.getElementById('notification-count').innerText = data.count; // Mettre à jour le compteur
                        });
                }

                // Appeler la fonction pour charger les notifications au chargement de la page
                document.addEventListener('DOMContentLoaded', loadNotifications);
            </script>
        </div>
    </div>
</nav>
