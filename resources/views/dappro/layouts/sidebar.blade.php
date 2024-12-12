  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a href="{{ route('dashboard.direction3') }}" class="{{ Request::routeIs('dashboard.direction3') ? 'active' : '' }}">
          <i class="bi bi-grid"></i>
          <span>Tableau de Bord</span>
        </a>
      </li><!-- End Dashboard Nav -->

      @if(auth()->user()->role == 'Admin')

      <li class="nav-item">
        <a class="nav-link collapsed {{ Request::is('admin/*') ? 'active' : '' }}" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Administration</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse {{ Request::is('admin/*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('admin.Utilisateur.create') }}" class="{{ Request::routeIs('admin.Utilisateur.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Utilisateurs</span>
            </a>
          </li>
          <li>
            <a href="{{ route('admin.categorieArticle.create') }}" class="{{ Request::routeIs('admin.categorieArticle.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Catégories Articles</span>
            </a>
          </li>
          <li>
            <a href="{{ route('admin.uniteArticle.create') }}" class="{{ Request::routeIs('admin.uniteArticle.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Unités Articles</span>
            </a>
          </li>
          <li>
            <a href="{{ route('admin.Article.create') }}" class="{{ Request::routeIs('admin.Article.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Articles</span>
            </a>
          </li>
          <li>
            <a href="{{ route('admin.fournisseur.create') }}" class="{{ Request::routeIs('admin.fournisseur.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Fournisseurs</span>
            </a>
          </li>
          <li>
            <a href="{{ route('admin.direction.create') }}" class="{{ Request::routeIs('admin.direction.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Directions</span>
            </a>
          </li>
          <li>
            <a href="{{ route('admin.division.create') }}" class="{{ Request::routeIs('admin.division.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Divisions</span>
            </a>
          </li>
          <li>
            <a href="{{ route('admin.bureau.create') }}" class="{{ Request::routeIs('admin.bureau.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Bureaux</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed {{ Request::is('admin/*') ? 'active' : '' }}" data-bs-target="#components-nav4" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Bureau Fournitures</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav4" class="nav-content collapse {{ Request::is('admin/*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('admin.Niveau.create') }}" class="{{ Request::routeIs('admin.Niveau.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Niveaux Scolaires</span>
            </a>
          </li>
          <li>
            <a href="{{ route('admin.Cycle.create') }}" class="{{ Request::routeIs('admin.Cycle.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Cycle Bulletins</span>
            </a>
          </li>
          <li>
            <a href="{{ route('admin.Option.create') }}" class="{{ Request::routeIs('admin.Option.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Options Bulletins</span>
            </a>
          </li>
          <li>
            <a href="{{ route('admin.Kelasi.create') }}" class="{{ Request::routeIs('admin.Kelasi.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Classes Bulletins</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->
      @endif

      @if(auth()->user()->role == 'User')

      <li class="nav-item">
        <a class="nav-link collapsed {{ Request::routeIs('mouvement.gestion.*') || Request::routeIs('mouvement.EntreeStock.*') || Request::routeIs('mouvement.SortieStock.*') || Request::routeIs('mouvement.reporting.*') ? '' : 'collapsed' }}" data-bs-target="#components-nav1" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Mouvement Stock</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav1" class="nav-content collapse {{ Request::routeIs('mouvement.gestion.*') || Request::routeIs('mouvement.EntreeStock.*') || Request::routeIs('mouvement.SortieStock.*') || Request::routeIs('mouvement.reporting.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('mouvement.gestion.create') }}" class="{{ Request::routeIs('mouvement.gestion.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Gestion</span>
            </a>
          </li>
          <li>
            <a href="{{ route('mouvement.EntreeStock.create') }}" class="{{ Request::routeIs('mouvement.EntreeStock.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Entrée</span>
            </a>
          </li>
          <li>
            <a href="{{ route('mouvement.SortieStock.create') }}" class="{{ Request::routeIs('mouvement.SortieStock.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Sortie</span>
            </a>
          </li>
          <li>
            <a href="{{ route('mouvement.reporting.create') }}" class="{{ Request::routeIs('mouvement.reporting.*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Reporting</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->

      @endif
        <!--

        <li class="nav-item">
            <a class="nav-link collapsed" href="">
            <i class="bi bi-person"></i>
            <span>Utilisateurs</span>
            </a>
        </li>

        End Profile Page Nav -->

    @if(auth()->user()->role == 'Super-Utilisateur')

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav2" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Etat de Besoin</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav2" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="">
              <i class="bi bi-circle"></i><span>Nouveau</span>
            </a>
          </li>
          <li>
            <a href="components-accordion.html">
              <i class="bi bi-circle"></i><span>Liste</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav3" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Bon de Commandes</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav3" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="components-alerts.html">
              <i class="bi bi-circle"></i><span>Nouveau</span>
            </a>
          </li>
          <li>
            <a href="components-accordion.html">
              <i class="bi bi-circle"></i><span>Liste</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav4" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Demande d'achat</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav4" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="components-alerts.html">
              <i class="bi bi-circle"></i><span>New</span>
            </a>
          </li>
          <li>
            <a href="components-accordion.html">
              <i class="bi bi-circle"></i><span>Liste</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav5" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Reporting</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav5" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="components-alerts.html">
              <i class="bi bi-circle"></i><span>Entrée</span>
            </a>
          </li>
          <li>
            <a href="components-accordion.html">
              <i class="bi bi-circle"></i><span>Sortie</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->

    @endif
    </ul>

  </aside><!-- End Sidebar-->

