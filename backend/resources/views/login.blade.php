<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Connexion</title>
</head>
<body>

<h2>Formulaire de Connexion</h2>

<form method="POST" action="{{ url('/login/admin') }}">
    @csrf

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" placeholder="Votre adresse e-mail" required>

    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>

    <button type="submit">Se connecter</button>
</form>

</body>
</html>
