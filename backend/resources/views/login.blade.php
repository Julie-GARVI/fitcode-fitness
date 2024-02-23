<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://kit.fontawesome.com/a3ee4a04c9.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back-office</title>
    <link rel="stylesheet" href="/assets/css/reset.css">
    <link rel="stylesheet" href="/assets/css/login.css">

    <script>
        setTimeout(function() {
            const alertErrors = document.querySelector(".alert");
            console.log(alertErrors);
            alertErrors.style.display = "none";
        }, 5000); 
        
    </script>
</head>

    <body>
        <main class="form-wrapper">
            <section class="form-container">
                
                <h1>Bienvenue sur l'espace administrateur</h1>
                <h2>Connectez-vous à votre compte</h2>
                <form method="POST" action="{{ url('/login/admin') }}">
                    @csrf
                    <div class="form-block">
                        <div class="form-value">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" placeholder="Votre adresse e-mail" required>
                        </div>
                        <div class="form-value">
                            <label for="password">Mot de passe:</label>
                            <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>
                            <i class="fa-solid fa-sm fa-eye" aria-hidden="true"></i>
                        </div>
           
                        <div class="alert" style="display: {{ $errors->any() ? 'block' : 'none' }}">
                        @if ($errors->any())
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>Erreur ! {{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                            <button type="submit">Se connecter</button>
                    </div>
                </form>
            </section>
        </main>

        <script>
        function togglePasswordVisibility() { // Ajout de parenthèses après le nom de la fonction
            const eye = document.querySelector(".fa-eye");
            eye.addEventListener("click", () => { 
                console.log(eye);
                const passwordFields = document.querySelector("#password"); // Utilisation de querySelectorAll
                
                    if (password.type === "password") {
                        password.type = "text";
                    } else {
                        password.type = "password";
                    }
                });
        
        }
        togglePasswordVisibility(); // Appel de la fonction pour l'initialiser
        </script>
    </body>
</html>
