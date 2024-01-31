<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="keywords" content="salle de sport, exercices, entrainement, coachs, fitness, musculation, yoga, aqua-gym, cardio" />
    <meta name="description" content="FitCode Fitness - Accédez à votre espace sportif personnel en ligne, suivez les exercices de quatre coachs qualifiés et créez vos propres séances d'entraînement." />
    <link rel="icon" type="image/png" href="/home.png" />
    <script src="https://kit.fontawesome.com/a3ee4a04c9.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nouvel exercice</title>
    <link rel="stylesheet" href="/assets/css/reset.css">
    <link rel="stylesheet" href="/assets/css/exercices-add.css">
    <script type="module" crossorigin src="/assets/index-643029e4.js"></script>
    <link rel="stylesheet" href="/assets/index-7d46831a.css">
  </head>
  <body>

<main class="new-exercice">
    <section class="modal-wrapper">
        <form class="form-crud" method="POST" action="{{ url('/exercices/add') }}">
        @csrf

            <div class="value categories">
            <input type="hidden" name="category_id" value=2>
            </div>

            <div class="value multimedia">
            <input type="hidden" name="multimedia_id" value=5>
            </div>

            <div class="value name">
                <label for="name">Nom de l'exercice :</label>
                <input type="text" id="name" name="name" class="name create" placeholder="Développé militaire" bind:value={name}>
            </div>
            <div class="value time">
                <label for="time">Durée de l'exercice (heure:minutes:secondes) :</label>
                <input type="time" id="time" class="time create" name="time" pattern="[0-5][0-9]:[0-5][0-9]" placeholder="HH:MM:SS" step='1' bind:value={time}>
            </div>

            <div class="value instructions">
                <label for="instructions">Instructions :</label>
                <textarea class="instructions create" id="instructions" name="instructions" placeholder="Soulever la barre des hanches aux épaules..." bind:value={instructions}></textarea>
            </div>

            <div class="btn-block">
                <button type="submit" class="btn-submit" aria-label="Bouton de validation de l'exercice">Valider</button>
            </div>
        </form>
    </section>
</main>
</body>
</html>

