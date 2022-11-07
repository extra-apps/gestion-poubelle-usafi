<header class="header-mobile d-block d-lg-none">
    <div class="header-mobile__bar">
        <div class="container-fluid">
            <div class="header-mobile-inner">
                <a href="#" class="logo d-flex justify-content-center bg-white">
                    <img class="m-2" src="{{ asset('assets/') }}/images/logo.jpg"
                        style="width: 100%; height: 80px;">
                </a>
                <button class="hamburger hamburger--slider" type="button">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <nav class="navbar-mobile">
        <div class="container-fluid">
            <ul class="navbar-mobile__list list-unstyled">
                <li>
                    <a href="{{ route('equipe-projet.accueil') }}">
                        <i class="fas fa-chart-bar"></i>Tableau de bord</a>
                </li>
                <li>
                    <a href="{{ route('equipe-projet.projet') }}">
                        <i class="fas fa-list"></i>Projets</a>
                </li>
                <li>
                    <a href="{{ route('equipe-projet.equipe') }}">
                        <i class="fas fa-users"></i>Equipe projet</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo d-flex justify-content-center bg-white">
        <a href="#">
            <img class="m-2" src="{{ asset('assets/') }}/images/logo.jpg"
                style="width: 100%; height: 80px;">
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li>
                    <a href="{{ route('equipe-projet.accueil') }}">
                        <i class="fas fa-chart-bar"></i>Tableau de bord</a>
                </li>
                <li>
                    <a href="{{ route('equipe-projet.projet') }}">
                        <i class="fas fa-list"></i>Projets</a>
                </li>
                <li>
                    <a href="{{ route('equipe-projet.equipe') }}">
                        <i class="fas fa-users"></i>Equipe projet</a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
