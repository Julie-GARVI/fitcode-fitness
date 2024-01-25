<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back-office</title>
    <link rel="stylesheet" href="/assets/css/reset.css">
    <link rel="stylesheet" href="/assets/css/login.css">
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
            </div>

            <button type="submit">Se connecter</button>

        </div>

    </form>

    </section>

</main>

</body>

</html>
