<header class="header-mobile d-block d-lg-none">
    <div class="header-mobile__bar">
        <div class="container-fluid">
            <div class="header-mobile-inner">
                <a href="#" class="logo d-flex justify-content-center bg-white shadow-none">
                    <img class="m-2" src="{{ asset('assets/') }}/images/logo1.png"
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
                    <a href="{{ route('client.accueil') }}">
                        <i class="fas fa-chart-bar"></i>Accueil</a>
                </li>
                <li>
                    <a href="#" data-toggle="modal" data-target="#com">
                        <i class="fas fa-comment"></i> Commentaire</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo d-flex justify-content-center bg-white shadow-none">
        <a href="#">
            <img class="m-2" src="{{ asset('assets/') }}/images/logo1.png"
                style="width: 100%; height: 80px;">
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li>
                    <a href="{{ route('client.accueil') }}">
                        <i class="fas fa-chart-bar"></i>Accueil</a>
                </li>
                <li>
                    <a href="#" data-toggle="modal" data-target="#com">
                        <i class="fas fa-comment"></i> Commentaire</a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<div class="modal fade" id="com" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="text-white">Laisser un commentaire</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="f-com">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Sujet</label>
                        <input name="sujet" required class="form-control" maxlength="100">
                    </div>
                    <div class="form-group">
                        <label for="">Commentaire</label>
                        <textarea name="commentaire" id="" cols="30" rows="10" class="form-control" maxlength="500"></textarea>
                    </div>
                    <div class="form-group">
                        <div id="rep"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-outline-info">
                        <span></span>
                        Envoyer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
