<!doctype html>
<html lang="fr">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{asset('login/assets/fonts/icomoon/style.css')}}">

        <link rel="stylesheet" href="{{asset('login/assets/css/owl.carousel.min.css')}}">

          <!-- Favicons -->
        <link href="{{asset('login/assets/favicon.png')}}" rel="icon">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{asset('login/assets/css/bootstrap.min.css')}}">

        <!-- Style -->
        <link rel="stylesheet" href="{{asset('login/assets/css/style.css')}}">

        <style>
            body {

              background-size: cover;
              background-repeat: no-repeat;
              background-position: center;
              min-height: 100vh;
              display: flex;
              justify-content: center;
              align-items: center;
            }

            .container {
                background-color: white;
                padding: 2rem;
                border-radius: 0.5rem;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
        </style>

        <title>senapi-web</title>
    </head>
    <body>

        <div class="content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <img src="{{asset('login/assets/images/red.jpg')}}" alt="Image" class="img-fluid">
                    </div>
                    <div class="col-md-6 ">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="text-center">
                                    <!-- <img src="{{asset('login/assets/favicon.png')}}" alt="Image" class="img-fluid"> -->
                                    <img src="{{asset('assets/img/logo-snp.png')}}" alt="Logo" style="width: 60px; height: 60px;" class="me-3">
                                    <h5>SENAPI-WEB</h5>
                                    <p class="mb-3">DIRECTION {{ $direction->designation }}</p>
                                </div>

                                <form action="{{ route('login', $direction->id) }}" method="POST">

                                    @csrf
                                    @method('POST')

                                    <div class="form-group first">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" id="email" required autofocus>
                                    </div>
                                    <div class="form-group last mb-4">
                                        <label for="password">Mot de Passe</label>
                                        <input type="password" name="password" class="form-control" id="password" required>
                                    </div>
                                    <div class="d-flex mb-5 align-items-center">
                                        <label class="control control--checkbox mb-0"><span class="caption">Se Souvenir de moi</span>
                                          <input type="checkbox" checked="checked"/>
                                          <div class="control__indicator"></div>
                                        </label>
                                        <span class="ml-auto"><a href="" class="forgot-pass">Mot de Passe oublié</a></span>
                                    </div>

                                    @if($errors->any())
                                        <div style="color: red; font-weight: bold;">
                                            {{ $errors->first() }}
                                        </div>
                                    @endif

                                    <input type="submit" value="Connexion" class="btn btn-block btn-primary">

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{asset('login/assets/js/jquery-3.3.1.min.js')}}"></script>
        <script src="{{asset('login/assets/js/popper.min.js')}}"></script>
        <script src="{{asset('login/assets/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('login/assets/js/main.js')}}"></script>
    </body>
</html>
