<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://kit.fontawesome.com/a3ee4a04c9.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercices admins</title>
    <link rel="stylesheet" href="/assets/css/reset.css">
    <link rel="stylesheet" href="/assets/css/exercices.css">
</head>

<body>
    <h1>Votre espace administrateur</h1>
<!--------------------------------------ADMIN------------------------------------------------------>
<div class="profil-container">
    <div class="profil-items">

    @php $firstExercice = $exercices->first(); @endphp

        <div class="profil-block">
            <img src="{{ asset('coachs/' . $firstExercice->user->multimedia->picture_path) }}"  class="profil-picture" alt="Photo de l'admin">
        </div>
        <div class="profil-row1">
            <div class="profil name">
                <h2>{{$firstExercice->user->firstname }}  {{ $firstExercice->user->lastname }}, <span class="age-profil">{{ $firstExercice->user->age }} ans</span></h2>
            </div>
            <div class="profil email">
                <p><i class="fa-solid fa-paper-plane pink"></i>{{ $firstExercice->user->email}}</p>
            </div>
        </div>

        <div class="profil-row2">
            <div class="item number">
                <div class="icon-block">
                    <i class="fa-solid fa-person-running fa-xl"></i>
                    <p><span class="counter">3</span> exercices</p>
                </div>
            </div>
            <div class="item category">
                <div class="icon-block">
                    <i class="fa-solid fa-medal fa-lg"></i>
                    <p>{{ $firstExercice->category->name}}</p>
                </div>
            </div>
    </div>
</div>


<!--------------------------------------EXERCICES------------------------------------------------------>

<div class="wrapper-admins-exercices">
    <h2>Exercices de {{ $firstExercice->category->name}}</h2>

    <div class="exercice-container">
        @foreach ($exercices as $exercice)
            <div class="block-exercice">

                <div class="exercice-name">
                <h3>{{ $exercice->name }}</h3>
                </div>

                <div class="img-block">
                    <img src="/assets/basket.webp" class="exercice-picture" alt="">
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
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
