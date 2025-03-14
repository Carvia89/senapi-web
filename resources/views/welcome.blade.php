<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="utf-8">
        <title>senapi-web</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wdth,wght@0,75..100,300..800;1,75..100,300..800&display=swap" rel="stylesheet">

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="{{asset('assets/lib/animate/animate.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    <script type="text/javascript" src="https://gc.kis.v2.scr.kaspersky-labs.com/FD126C42-EBFA-4E12-B309-BB3FDD723AC1/main.js?attr=e1iA0cClSzi-kV7ghgjwEx0X3zQRG0GtqB5JWA7mbrHdjWiRew8-m2tQhsmvPKYl5EWHTOAJAqw6KuSdZMmlJw" charset="UTF-8"></script></head>

    <body>

        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Navbar & Hero Start -->
        <div class="container-fluid nav-bar sticky-top px-4 py-2 py-lg-0">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a href="" class="navbar-brand p-0">
                    <h1 class="display-6 text-dark">
                        <img src="{{asset('assets/img/logo-snp.png')}}" alt="Logo" style="width: 60px; height: 60px;" class="me-3">
                        <span style="color: red;">S</span><span style="color: skyblue;">ENAPI</span>
                    </h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                        <a href="#" class="nav-item nav-link active">Accueil</a>
                        <a href="#" class="nav-item nav-link">Services</a>
                        <a href="#" class="nav-item nav-link">Gallerie</a>

                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Directions</a>
                            <div class="dropdown-menu m-0">
                                @foreach($directions as $direction)
                                    <a href="#" class="dropdown-item">{{ $direction->designation }}</a>
                                @endforeach
                            </div>
                        </div>
                        <a href="#" class="nav-item nav-link">Contacts</a>
                    </div>
                    <div class="team-icon d-none d-xl-flex justify-content-center me-3">
                        <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-square btn-light rounded-circle mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <!-- <a href="{{ route('login.DG') }}" class="btn btn-primary rounded-pill py-2 px-4 flex-shrink-0">Go Pass</a> -->
                </div>
            </nav>
        </div>
        <!-- Navbar & Hero End -->

        <!-- Carousel Start -->
        <div class="header-carousel owl-carousel">
            <div class="header-carousel-item">
                <img src="{{asset('assets/img/img9.jpg')}}" class="img-fluid w-100" alt="Image">
                <div class="carousel-caption">
                    <div class="container align-items-center py-4">
                        <div class="row g-5 align-items-center">
                            <div class="col-xl-7 fadeInLeft animated" data-animation="fadeInLeft" data-delay="1s" style="animation-delay: 1s;">
                                <div class="text-start">
                                    <h4 class="text-primary text-uppercase fw-bold mb-4">Bienvenue au SENAPI-WEB</h4>
                                    <h1 class="display-4 text-uppercase text-white mb-4">La plateforme digitale du Service</h1>
                                    <p class="mb-4 fs-5">Cette plateforme mise sur pied par la DANTIC, est une solution informatique visant la digitalisation de l'administration du Service National des Approvisionnements et de l'Imprimerie.
                                    </p>
                                    <div class="d-flex flex-shrink-0">
                                        <a class="btn btn-primary rounded-pill text-white py-3 px-5" href="#">Nos applications</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5 fadeInRight animated" data-animation="fadeInRight" data-delay="1s" style="animation-delay: 1s;">
                                <div class="ticket-form p-5">
                                    <h2 class="text-dark text-uppercase mb-4">IDENTIFIEZ-VOUS</h2>
                                    <form method="POST" action="{{ route('page.accueil') }}" class="dynamic-bureau-form">
                                        @csrf
                                        <div class="row g-4">
                                            <div class="col-12">
                                                <select name="direction_id" class="form-select border-0 py-2 @error('direction_id') is-invalid @enderror" id="direction_id_1">
                                                    <option value="">Sélectionnez votre direction</option>
                                                    @foreach ($directions as $direction)
                                                        <option value="{{ $direction->id }}">{{ $direction->designation }}</option>
                                                    @endforeach
                                                </select>
                                                @error('direction_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <input type="email" class="form-control border-0 py-2" id="email1" name="email" placeholder="Votre adresse email" required>
                                            </div>
                                            <div class="col-12">
                                                <input type="password" class="form-control border-0 py-2" id="password1" name="password" placeholder="Votre Mot de Passe" required>
                                            </div>
                                            <div class="col-12 d-flex justify-content-between align-items-center text-white">
                                                <div>
                                                    <input type="checkbox" id="remember" name="remember">
                                                    <label for="remember">Se souvenir de moi</label>
                                                </div>
                                            </div>
                                            @if($errors->any())
                                                <div class="mb-0" style="color: red">
                                                    {{ $errors->first() }}
                                                </div>
                                            @endif
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary w-100 py-2 px-5">Valider</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Carousel End -->

    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('assets/lib/wow/wow.min.js')}}"></script>
    <script src="{{asset('assets/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('assets/lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('assets/lib/counterup/counterup.min.js')}}"></script>
    <script src="{{asset('assets/lib/lightbox/js/lightbox.min.js')}}"></script>
    <script src="{{asset('assets/lib/owlcarousel/owl.carousel.min.js')}}"></script>


    <!-- Template Javascript -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <style>
        .text-white {
            color: black;
        }
    </style>
    </body>

</html>
