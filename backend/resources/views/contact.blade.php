
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://kit.fontawesome.com/a3ee4a04c9.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back-Office</title>
    <link rel="stylesheet" href="/assets/css/reset.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/exercices.css">
    <link rel="stylesheet" href="/assets/css/contact.css">
</head>

<body>
    
<header class="wrapper-menu">
    <nav class="nav-menu">
        <ul class="main-menu">
            <li class="menuitem"><a href="/exercices/admin" class="nav-menu__link" aria-label="Liens vers la page d'accueil">Exercice</a></li>
            <li class="menuitem"><a href="/contact" class="nav-menu__link" aria-label="Liens vers la page d'accueil">Contact</a></li>
            <li role="menuitem">
                    <button type="submit" form="logout-form" id="deconnexion" class="nav-menu__link" aria-label="Se déconnecter" title="Déconnexion">
                        <i class="fa-solid fa-right-from-bracket fa-lg"></i>
                    </button>

                <form id="logout-form" action="{{ route('logout.admin') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>
</header>

<h1>Contact adhérent</h1>

<main class="contact-wrapper">

    <section class="container-contact">

    <h2 class="counter-contact">@php echo count($contacts); @endphp Résultats :</h2>

     @foreach ($contacts as $contact)
     <div class="contact-block">
        <div class="username">
            <div class="credentials">
                <p>{{$contact->lastname}} <span class="firstname"> {{$contact->firstname}} </span></p>
            </div>
            <p><i class="fa-solid fa-paper-plane pink"></i>{{$contact->email}}</p>
        </div>
        <div class="message">
            <p>{{$contact->message}}<p>
        <div class="icon">
            <i class="fa-solid fa-user"></i>
        </div>
        </div>
     </div>

     @endforeach
    </section>

</main>