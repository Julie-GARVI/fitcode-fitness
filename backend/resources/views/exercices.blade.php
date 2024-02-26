
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
            <li class="menuitem"><a href="/exercices/admin" class="nav-menu__link" aria-label="Liens vers la page d'accueil">Exercices</a></li>
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

    <h1>Votre espace administrateur</h1>
<!--------------------------------------ADMIN------------------------------------------------------>
<main class="exercices-main-page">
    <section class="profil-container">
        <div class="profil-items">

        @php $firstExercice = $exercices->first(); @endphp

            <div class="profil-block">
                <img src="{{ asset('users/' . $firstExercice->user->multimedia->picture_path) }}"  class="profil-picture" alt="Photo de l'admin">
            </div>
            <div class="profil-row1">
                <div class="profil name">
                    <h2>{{$firstExercice->user->firstname}}  {{ $firstExercice->user->lastname }}, <span class="age-profil">{{ $firstExercice->user->age }} ans</span></h2>
                </div>
                <div class="profil email">
                    <p><i class="fa-solid fa-paper-plane pink"></i>{{ $firstExercice->user->email}}</p>
                </div>
            </div>

            <div class="profil-row2">
                <div class="item number">
                    <div class="icon-block">
                        <i class="fa-solid fa-person-running fa-xl"></i>
                        <p><span class="counter">{{ count($exercices) }}</span> exercices</p>
                    </div>
                </div>

                <div class="item category">
                    <div class="icon-block">
                        <i class="fa-solid fa-medal fa-lg"></i>
                        <p id="category">{{ $firstExercice->category->name}}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!--------------------------------NOUVEL EXERCICE--------------------------------------------------------->

    <section class="exercice-crud">
        <a href="/exercices/admin/add" class="link-open" aria-label="Ajouter un exercice">
        <i class="fa-solid fa-plus fa-xl"></i><br> Nouvel exercice
        </a>
    </section>

    <!-------------------------------LISTE DES EXERCICES------------------------------------------------------>

    <section class="wrapper-admins-exercices">
        <h2>Exercices de {{ $firstExercice->category->name}}</h2>

        <div class="exercice-container">
            @foreach ($exercices as $exercice)
                <div class="block-exercice">

                    <div class="exercice-name">
                    <h3>{{ $exercice->name }}</h3>
                    </div>

                    <div class="img-block">
                        <img src="{{ asset('exercices/' . $exercice->multimedia->picture_path) }}" class="exercice-picture" alt="">
                    </div>

                    <div class="exercice-content">
                        <div class="exercice-category">
                            <p>{{ $exercice->category->name}}</p>
                        </div>
                    
                        <span><p>{{ $exercice->level }}</p></span>
                        <p>{{ $exercice->formatted_time }}</p>
                    </div>

                    <div class="exercice-instruction">
                            <p>{{ $exercice->instructions }}</p>
                    </div>

                    <div class="btn-items">
                        <a href="/exercices/admin/edit/{{ $exercice->id }}" aria-label="Aller à la page modifier un exercice" use:link>
                            <button class="btn-create" id="buttonEdit">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                        </a>
                        <meta name="base-url" content="{{ url('/') }}">
                        <button type="button" class="btn-create" id="buttonDelete" data-id="{{ $exercice->id }}" onclick="deleteExercice('{{ $exercice->id }}')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>

                    <script>
                    function deleteExercice(exerciceId) {
                        if (confirm('Voulez-vous vraiment supprimer cet exercice ?')) {
                            fetch('/exercices/' + exerciceId, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Redirigez ou effectuez d'autres actions après la suppression réussie
                                window.location.reload();
                            })
                            .catch(error => {
                                console.error('Erreur:', error);
                            });
                        }
                    }
                </script>

                </div>
            @endforeach

    </section>
</main>
</body>
</html>
