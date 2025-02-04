<!doctype html>
<html lang="fr">
<head>
    <title>senapi-web</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <style>
        /* Importing fonts from Google */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

        /* Reseting */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            position: relative;
            height: 100vh; /* Utiliser 100vh pour s'assurer que l'image couvre toute la hauteur de la fenêtre */
            overflow: hidden; /* Empêcher le débordement */
            display: flex; /* Utiliser Flexbox pour centrer le contenu */
            justify-content: center; /* Centrer horizontalement */
            align-items: center; /* Centrer verticalement */
        }

        body::before {
            content: '';
            background: url('{{ asset('assets/img/img3.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            filter: blur(5px); /* Appliquer le flou à l'image d'arrière-plan */
            z-index: 1; /* Mettre l'image derrière le contenu */
        }

        .wrapper {
            position: relative; /* Positionner le contenu au-dessus du flou */
            max-width: 350px;
            min-height: 500px;
            padding: 40px 30px 30px 30px;
            background-color: rgba(236, 240, 243, 0.8); /* Couleur de fond semi-transparente */
            border-radius: 15px;
            box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.2); /* Atténuer l'éclat des bordures */
            z-index: 2; /* Mettre le formulaire au-dessus de l'image floue */
        }

        .logo {
            width: 80px;
            margin: auto;
        }

        .logo img {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0px 0px 3px #5f5f5f,
                0px 0px 0px 5px rgba(236, 240, 243, 0.8),
                8px 8px 15px rgba(167, 170, 167, 0.5),
                -8px -8px 15px rgba(255, 255, 255, 0.5);
        }

        .wrapper .name {
            font-weight: 600;
            font-size: 1.4rem;
            letter-spacing: 1.3px;
            padding-left: 10px;
            color: #555;
        }

        .wrapper .form-field input {
            width: 100%;
            display: block;
            border: none;
            outline: none;
            background: none;
            font-size: 1.2rem;
            color: #666;
            padding: 10px 15px 10px 10px;
        }

        .wrapper .form-field {
            padding-left: 10px;
            margin-bottom: 20px;
            border-radius: 20px;
            box-shadow: inset 8px 8px 8px rgba(203, 206, 209, 0.5), inset -8px -8px 8px rgba(255, 255, 255, 0.5);
        }

        .wrapper .form-field .fas {
            color: #555;
        }

        .wrapper .btn {
            box-shadow: none;
            width: 100%;
            height: 40px;
            background-color: #03A9F4;
            color: #fff;
            border-radius: 25px;
            box-shadow: 3px 3px 3px rgba(177, 177, 177, 0.5),
                -3px -3px 3px rgba(255, 255, 255, 0.5);
            letter-spacing: 1.3px;
        }

        .wrapper .btn:hover {
            background-color: #039BE5;
        }

        .wrapper a {
            text-decoration: none;
            font-size: 0.8rem;
            color: #03A9F4;
        }

        .wrapper a:hover {
            color: #039BE5;
        }

        @media(max-width: 380px) {
            .wrapper {
                margin: 30px 20px;
                padding: 40px 15px 15px 15px;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="logo">
            <img src="{{ asset('assets/img/logo-snp.png') }}" alt="Logo">
        </div>
        <div class="text-center mt-4 name">
            SENAPI-WEB
        </div>
        <form class="p-3 mt-3" action="{{ route('DG.login') }}" method="POST">
            @csrf
            @method('POST')

            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="email" name="email" id="email" placeholder="E-mail" required autofocus>
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="password" id="password" placeholder="Mot de passe" required>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <button type="submit" class="btn mt-3">Se Connecter</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
</body>
</html>