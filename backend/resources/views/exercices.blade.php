<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercices admins</title>
    <link rel="stylesheet" href="/assets/css/reset.css">
</head>

<body>
    <h1>Page admin</h1>
<!--------------------------------------ADMIN------------------------------------------------------>
    <div class="profil-block">
        <img src="/assets/basket.webp" class="profil-picture" alt="">
    </div>
    @foreach ($exercices as $exercice)
    <div class="profil-row1">
        <div class="profil name">
            <h2>{{ $exercice->user->firstname }}  {{ $exercice->user->lastname }}, <span class="age-profil">{{ $exercice->user->age }} ans</span></h2>
        </div>
        <div class="profil email">
            <p><i class="fa-solid fa-paper-plane pink"></i>{{ $exercice->user->email}}</p>
        </div>
    </div>

    <div class="profil-row2">
        <div class="profil exercice-number">
            <div class="icon-block">
                <i class="fa-solid fa-person-running fa-xl"></i>
                <p><span class="counter">3</span> exercices</p>
        </div>
    </div>

    <div class="profil category">
      <div class="icon-block">
        <i class="fa-solid fa-medal fa-lg"></i>
        <p>catégorie</p>
      </div>
    </div>


<!--------------------------------------EXERCICES------------------------------------------------------>

<div class="block-exercice">
    <div class="exercice-name">
        <h3>{{ $exercice->name }}</h3>
</div>

<div class="img-block">
    <img src="/assets/basket.webp" class="exercice-picture" alt="">
</div>

<div class="exercice-category">
    <p>catégorie</p>
</div>

<div class="exercice-content">
        <span><p>{{ $exercice->level }}</p></span>
    <p>{{ $exercice->time }}</p>
    <div class="exercice-instruction">
        <p>{{ $exercice->instructions }}</p>
    </div>
</div>

@endforeach



</body>
</html>
