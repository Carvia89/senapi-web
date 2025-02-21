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
                        <a href="gallery.html" class="nav-item nav-link">Gallerie</a>

                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Directions</a>
                            <div class="dropdown-menu m-0">
                                @foreach($directions as $direction)
                                    <a href="{{ route('login.show', ['direction_id' => $direction->id]) }}" class="dropdown-item">{{ $direction->designation }}</a>
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
                    <a href="{{ route('login.DG') }}" class="btn btn-primary rounded-pill py-2 px-4 flex-shrink-0">Go Pass</a>
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
<form method="POST" action="{{ route('page.accueil') }}">
    @csrf
    <div class="row g-4">
        <div class="col-12">
            <select name="direction_id" class="form-select border-0 py-2 
            @error('direction_id') is-invalid @enderror" 
            id="direction_id" aria-label="Default select example">
                <option value="">Sélectionnez la direction</option>
                @foreach ($directions as $direction)
                    <option value="{{ $direction->id }}">{{ $direction->designation }}</option>
                @endforeach
            </select>
            @error('direction_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-12">
            <select name="bureau_id" class="form-select border-0 py-2 
            @error('bureau_id') is-invalid @enderror" 
            id="bureau_id" aria-label="Default select example">
                <option value="">Sélectionnez...</option>
                @foreach ($bureaux as $bureau)
                    <option value="{{ $bureau->id }}">{{ $bureau->designation }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12">
            <input type="email" class="form-control border-0 py-2" id="email" name="email" placeholder="Votre adresse email" required>
        </div>
        <div class="col-12">
            <input type="password" class="form-control border-0 py-2" id="password" name="password" placeholder="Votre Mot de Passe" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary w-100 py-2 px-5">Valider</button>
        </div>
    </div>
</form>

<script>
    function loadBureaus(directionId) {
        const bureauSelect = document.getElementById('bureau_id');

        // Réinitialiser le champ bureau_id
        bureauSelect.innerHTML = '<option value="">Sélectionnez...</option>';

        if (directionId) {
            fetch(`/get-bureaus/${directionId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur lors de la récupération des bureaux');
                    }
                    return response.json();
                })
                .then(data => {
                    // Vérifier si des données ont été retournées
                    if (data.length > 0) {
                        // Ajouter les options des bureaux
                        data.forEach(bureau => {
                            const option = document.createElement('option');
                            option.value = bureau.id;
                            option.textContent = bureau.designation;
                            bureauSelect.appendChild(option);
                        });
                    } else {
                        // Aucun bureau trouvé
                        const option = document.createElement('option');
                        option.textContent = 'Aucun bureau disponible';
                        bureauSelect.appendChild(option);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    const option = document.createElement('option');
                    option.textContent = 'Erreur lors du chargement des bureaux';
                    bureauSelect.appendChild(option);
                });
        }
    }
</script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Carousel End -->


        <!-- Feature Start -->

        <div class="container-fluid feature py-5">
            <div class="container py-5">
                <div class="row g-4">
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="feature-item">
                            <img src="{{asset('assets/img/img_LOFI.jpg')}}" class="img-fluid rounded w-100" alt="Image">
                            <div class="feature-content p-4">
                                <div class="feature-content-inner">
                                    <h4 class="text-white">GESTODIVE</h4>
                                    <p class="text-white">Una branche de la plateforme destinée à la gestion des matières premières et la vente des bulletins scolaires pour la Direction des Approvisionnements...
                                    </p>
                                    <a href="#" class="btn btn-primary rounded-pill py-2 px-4">Read More <i class="fa fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="feature-item">
                            <img src="{{asset('assets/img/img_LOFI.jpg')}}" class="img-fluid rounded w-100" alt="Image">
                            <div class="feature-content p-4">
                                <div class="feature-content-inner">
                                    <h4 class="text-white">COMPT-APP</h4>
                                    <p class="text-white">Une branche de la plateforme qui gère le circuit de la comptabilité de la Direction Administrative & Financière de l'ordonnancement  à la liquidation...
                                    </p>
                                    <a href="#" class="btn btn-primary rounded-pill py-2 px-4">Read More <i class="fa fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="feature-item">
                            <img src="{{asset('assets/img/img_LOFI.jpg')}}" class="img-fluid rounded w-100" alt="Image">
                            <div class="feature-content p-4">
                                <div class="feature-content-inner">
                                    <h4 class="text-white">GECIPRO</h4>
                                    <p class="text-white">Une branche de la plateforme destinée à la gestion du circuit de l'Imprimerie pour la Direction de Production, de la facturation à la livraison...
                                    </p>
                                    <a href="#" class="btn btn-primary rounded-pill py-2 px-4">Read More <i class="fa fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Feature End -->

        <!-- About Start -->
        <div class="container-fluid about pb-5">
            <div class="container pb-5">
                <div class="row g-5">

                </div>
            </div>
        </div>
        <!-- About End -->


        <!-- Service Start -->
        <div class="container-fluid service py-5">
            <div class="container service-section py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">Nos Services</h4>
                    <h1 class="display-5 text-white mb-4">Les différents services du SENAPI</h1>
                    <p class="mb-0 text-white">Nous sommes un service public de l'Etat Congolais, sous tutelle du Ministère de Budget. Nous sommes l'Imprimerie Nationale et à ce titre, imprimons les imprimés de valeurs. Nos horaires de travail sont dépendants de la Fonction Publique, tels que :
                    </p>
                </div>
                <div class="row g-4">
                    <div class="col-0 col-md-1 col-lg-2 col-xl-2"></div>
                    <div class="col-md-10 col-lg-8 col-xl-8 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="service-days p-4">
                            <div class="py-2 border-bottom border-top d-flex align-items-center justify-content-between flex-wrap"><h4 class="mb-0 pb-2 pb-sm-0">Lundi - Vendredi</h4> <p class="mb-0"><i class="fas fa-clock text-primary me-2"></i>08:00 - 16:00 </p></div>
                            <div class="py-2 border-bottom d-flex align-items-center justify-content-between flex-shrink-1 flex-wrap"><h4 class="mb-0 pb-2 pb-sm-0">Samedi - Dimanche (Jours Fériés) </h4> <p class="mb-0"><i class="fas fa-clock text-primary me-2"></i>00:00 - 23:59</p></div>
                        </div>
                    </div>
                    <div class="col-0 col-md-1 col-lg-2 col-xl-2"></div>

                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="service-item p-4">
                            <div class="service-content">
                                <div class="mb-4">
                                    <i class="fas fa-print fa-4x"></i>
                                </div>
                                <a href="#" class="h4 d-inline-block mb-3">SERIGRAPHIE</a>
                                <p class="mb-0">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Amet vel beatae numquam.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="service-item p-4">
                            <div class="service-content">
                                <div class="mb-4">
                                    <i class="fas fa-print fa-4x"></i>
                                </div>
                                <a href="#" class="h4 d-inline-block mb-3">OFFSET</a>
                                <p class="mb-0">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Amet vel beatae numquam.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="service-item p-4">
                            <div class="service-content">
                                <div class="mb-4">
                                    <i class="fas fa-print fa-4x"></i>
                                </div>
                                <a href="#" class="h4 d-inline-block mb-3">NUMERIQUE</a>
                                <p class="mb-0">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Amet vel beatae numquam.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Service End -->
<br>
<br>
        <!-- Blog Start -->
        <div class="container-fluid blog pb-5">
            <div class="container pb-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">Notre Catalogue</h4>
                    <h1 class="display-5 mb-4">Les imprimés de valeur</h1>
                    <p class="mb-0">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tenetur adipisci facilis cupiditate recusandae aperiam temporibus corporis itaque quis facere, numquam, ad culpa deserunt sint dolorem autem obcaecati, ipsam mollitia hic.
                    </p>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="blog-item">
                            <div class="blog-img">
                                <a href="#">
                                    <img src="{{asset('assets/img/img_CIRC.jpg')}}" class="img-fluid w-100 rounded-top" alt="Image">
                                </a>
                                <div class="blog-category py-2 px-4">Circulaires et Brévets</div>
                                <div class="blog-date"><i class="fas fa-clock me-2"></i>August 19, 2024</div>
                            </div>
                            <div class="blog-content p-4">
                                <a href="#" class="h4 d-inline-block mb-4">Circulaire d'exécution de la LOFIP 2022</a>
                                <p class="mb-4">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ullam aspernatur nam quidem porro sapiente, neque a quibusdam....
                                </p>
                                <a href="#" class="btn btn-primary rounded-pill py-2 px-4">Read More <i class="fas fa-arrow-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="blog-item">
                            <div class="blog-img">
                                <a href="#">
                                    <img src="{{asset('assets/img/img_BDG.jpg')}}" class="img-fluid w-100 rounded-top" alt="Image">
                                </a>
                                <div class="blog-category py-2 px-4">Cabinet</div>
                                <div class="blog-date"><i class="fas fa-clock me-2"></i>August 19, 2024</div>
                            </div>
                            <div class="blog-content p-4">
                                <a href="#" class="h4 d-inline-block mb-4">L'Efficacité et la Rigueur dans la gestion des Finances Publiques</a>
                                <p class="mb-4">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ullam aspernatur nam quidem porro sapiente, neque a quibusdam....
                                </p>
                                <a href="#" class="btn btn-primary rounded-pill py-2 px-4">Read More <i class="fas fa-arrow-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="blog-item">
                            <div class="blog-img">
                                <a href="#">
                                    <img src="{{asset('assets/img/img_DOC.jpg')}}" class="img-fluid w-100 rounded-top" alt="Image">
                                </a>
                                <div class="blog-category py-2 px-4">Autres documents</div>
                                <div class="blog-date"><i class="fas fa-clock me-2"></i>August 19, 2024</div>
                            </div>
                            <div class="blog-content p-4">
                                <a href="#" class="h4 d-inline-block mb-4">Révues, livres, Calendriers et autres documents</a>
                                <p class="mb-4">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ullam aspernatur nam quidem porro sapiente, neque a quibusdam....
                                </p>
                                <a href="#" class="btn btn-primary rounded-pill py-2 px-4">Read More <i class="fas fa-arrow-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Blog End -->


        <!-- Team Start -->
        <div class="container-fluid team pb-5">
            <div class="container pb-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">Equipe de Développeurs</h4>
                    <h1 class="display-5 mb-4">Les développeurs de la DANTIC</h1>
                    <p class="mb-0">La mise sur pied et la maintenance de cette plateforme-web est l'oeuvre de développeurs du Bureau Réseau et Site Internet, de la Direction des Archives, Nouvelles Technologies de l'Information et Communication du SENAPI.
                    </p>
                </div>
                <div class="row g-4 justify-content-center">
                    <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="team-item p-4">
                            <div class="team-content">
                                <div class="d-flex justify-content-between border-bottom pb-4">
                                    <div class="text-start">
                                        <h4 class="mb-0">Charles THAMBA</h4>
                                        <p class="mb-0">Stagiaire</p>
                                    </div>
                                    <div>
                                        <img src="{{asset('assets/img/img_BVS.jpg')}}" class="img-fluid rounded" style="width: 100px; height: 100px;" alt="">
                                    </div>
                                </div>
                                <div class="team-icon rounded-pill my-4 p-3">
                                    <a class="btn btn-primary btn-sm-square rounded-circle me-3" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-circle me-3" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-circle me-3" href=""><i class="fab fa-linkedin-in"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-circle me-0" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                                <p class="text-center mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem, quibusdam eveniet itaque provident sequi deserunt.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-6 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="team-item p-4">
                            <div class="team-content">
                                <div class="d-flex justify-content-between border-bottom pb-4">
                                    <div class="text-start">
                                        <h4 class="mb-0">Alexis LUBOYA</h4>
                                        <p class="mb-0">Stagiaire</p>
                                    </div>
                                    <div>
                                        <img src="{{asset('assets/img/imgAlexis.png')}}" class="img-fluid rounded" style="width: 100px; height: 100px;" alt="">
                                    </div>
                                </div>
                                <div class="team-icon rounded-pill my-4 p-3">
                                    <a class="btn btn-primary btn-sm-square rounded-circle me-3" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-circle me-3" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-circle me-3" href=""><i class="fab fa-linkedin-in"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-circle me-0" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                                <p class="text-center mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem, quibusdam eveniet itaque provident sequi deserunt.
                                </p>
                            </div>
                        </div>
                    </div>
                    <!--
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="team-item p-4">
                            <div class="team-content">
                                <div class="d-flex justify-content-between border-bottom pb-4">
                                    <div class="text-start">
                                        <h4 class="mb-0">Aimé LIYENGI</h4>
                                        <p class="mb-0">Chef de Bureau</p>
                                    </div>
                                    <div>
                                        <img src="{{asset('assets/img/team-3.jpg')}}" class="img-fluid rounded" style="width: 100px; height: 100px;" alt="">
                                    </div>
                                </div>
                                <div class="team-icon rounded-pill my-4 p-3">
                                    <a class="btn btn-primary btn-sm-square rounded-circle me-3" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-circle me-3" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-circle me-3" href=""><i class="fab fa-linkedin-in"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-circle me-0" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                                <p class="text-center mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem, quibusdam eveniet itaque provident sequi deserunt.
                                </p>
                            </div>
                        </div>
                    </div>
                    -->
                </div>
            </div>
        </div>
        <!-- Team End -->


        <!-- Testimonial Start -->
        <div class="container-fluid testimonial py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">Déclarations</h4>
                    <h1 class="display-5 text-white mb-4">Mots de Directeurs</h1>
                    <p class="text-white mb-0">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tenetur adipisci facilis cupiditate recusandae aperiam temporibus corporis itaque quis facere, numquam, ad culpa deserunt sint dolorem autem obcaecati, ipsam mollitia hic.
                    </p>
                </div>
                <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.2s">
                    <div class="testimonial-item p-4">
                        <p class="text-white fs-4 mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos mollitia fugiat, nihil autem reprehenderit aperiam maxime minima consequatur, nam iste eius velit perferendis voluptatem at atque neque soluta reiciendis doloremque.
                        </p>
                        <div class="testimonial-inner">
                            <div class="testimonial-img">
                                <img src="{{asset('assets/img/testimonial-1.jpg')}}" class="img-fluid" alt="Image">
                                <div class="testimonial-quote btn-lg-square rounded-circle"><i class="fa fa-quote-right fa-2x"></i>
                                </div>
                            </div>
                            <div class="ms-4">
                                <h4>Person Name</h4>
                                <p class="text-start text-white">Profession</p>
                                <div class="d-flex text-primary">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item p-4">
                        <p class="text-white fs-4 mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos mollitia fugiat, nihil autem reprehenderit aperiam maxime minima consequatur, nam iste eius velit perferendis voluptatem at atque neque soluta reiciendis doloremque.
                        </p>
                        <div class="testimonial-inner">
                            <div class="testimonial-img">
                                <img src="{{asset('assets/img/testimonial-2.jpg')}}" class="img-fluid" alt="Image">
                                <div class="testimonial-quote btn-lg-square rounded-circle"><i class="fa fa-quote-right fa-2x"></i>
                                </div>
                            </div>
                            <div class="ms-4">
                                <h4>Person Name</h4>
                                <p class="text-start text-white">Profession</p>
                                <div class="d-flex text-primary">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item p-4">
                        <p class="text-white fs-4 mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos mollitia fugiat, nihil autem reprehenderit aperiam maxime minima consequatur, nam iste eius velit perferendis voluptatem at atque neque soluta reiciendis doloremque.
                        </p>
                        <div class="testimonial-inner">
                            <div class="testimonial-img">
                                <img src="{{asset('assets/img/testimonial-3.jpg')}}" class="img-fluid" alt="Image">
                                <div class="testimonial-quote btn-lg-square rounded-circle"><i class="fa fa-quote-right fa-2x"></i>
                                </div>
                            </div>
                            <div class="ms-4">
                                <h4>Person Name</h4>
                                <p class="text-start text-white">Profession</p>
                                <div class="d-flex text-primary">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Déclarations End -->

        <!-- Footer Start -->
        <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-6 col-xl-4">
                        <div class="footer-item">
                            <a href="#" class="p-0">
                                <h4 class="display-6 text-white mb-4">
                                    <img src="{{asset('assets/img/logo-snp.png')}}" alt="Logo" style="width: 60px; height: 60px;" class="me-3">
                                    <span style="color: red;">S</span><span style="color: skyblue;">ENAPI</span>
                                </h4>
                            </a>
                            <p class="mb-2">Le Service National des Approvisionnements et de l'Imprimerie, sous tutelle du Ministère du Budget.</p>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-map-marker-alt text-primary me-3"></i>
                                <p class="text-white mb-0">1554, De la Rivière, Kinshasa - Gombe</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-envelope text-primary me-3"></i>
                                <p class="text-white mb-0">info@senapi.cd</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fa fa-phone-alt text-primary me-3"></i>
                                <p class="text-white mb-0">(+243) 81 00 00 000</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-2">
                        <div class="footer-item">
                            <h4 class="text-white mb-4">Quick Links</h4>
                            <a href="#"><i class="fas fa-angle-right me-2"></i> About Us</a>
                            <a href="#"><i class="fas fa-angle-right me-2"></i> Feature</a>
                            <a href="#"><i class="fas fa-angle-right me-2"></i> Attractions</a>
                            <a href="#"><i class="fas fa-angle-right me-2"></i> Contact us</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-2">
                        <div class="footer-item">
                            <h4 class="text-white mb-4">Support</h4>
                            <a href="#"><i class="fas fa-angle-right me-2"></i> Privacy Policy</a>
                            <a href="#"><i class="fas fa-angle-right me-2"></i> Support</a>
                            <a href="#"><i class="fas fa-angle-right me-2"></i> FAQ</a>
                            <a href="#"><i class="fas fa-angle-right me-2"></i> Help</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-4">
                        <div class="footer-item">
                            <h4 class="text-white mb-4">Horaire de travail</h4>
                            <div class="opening-date mb-3 pb-3">
                                <div class="opening-clock flex-shrink-0">
                                    <h6 class="text-white mb-0 me-auto">Lundi - Vendredi:</h6>
                                    <p class="mb-0"><i class="fas fa-clock text-primary me-2"></i> 08:00 - 16:00 </p>
                                </div>
                                <div class="opening-clock flex-shrink-0">
                                    <h6 class="text-white mb-0 me-auto">Sam - Dim: (Fériés)</h6>
                                    <p class="mb-0"><i class="fas fa-clock text-primary me-2"></i> 00:00 - 23:59 </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <!-- Copyright Start -->
        <div class="container-fluid copyright py-4">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-md-0">
                        <span class="text-body"><a href="#" class="border-bottom text-white"><i class="fas fa-copyright text-light me-2"></i>2025 DANTIC-SENAPI</a>, Tous droits reservés.</span>
                    </div>
                    <div class="col-md-6 text-center text-md-end text-body">
                        Designed By <a class="border-bottom text-white">TL_TEAM</a> Distributed By <a class="border-bottom text-white">Bureau Réseau et Site Internet</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Copyright End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-primary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>


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
    </body>

</html>
