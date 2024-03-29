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

    <script>
        setTimeout(function() {
            const alertErrors = document.querySelector(".alert");
            console.log(alertErrors);
            alertErrors.style.display = "none";
        }, 3500); 
        
    </script>

  </head>
  <body>

<main class="new-exercice">
            <section class="modal-wrapper">
            <form class="form-crud" method="POST" action="{{ url('/exercices/edit/' . $exercice->id) }}">
            @csrf
            @method('PUT')

            <div class="value name">
                <label for="name">Nom de l'exercice :</label>
                <input type="text" id="name" name="name" class="name create" placeholder="Développé militaire" value="{{ $exercice->name }}">
            </div>

            <div class="value time">
                <label for="time">Durée de l'exercice (heure:minutes:secondes) :</label>
                <input type="time" id="time" class="time update" name="time" pattern="[0-5][0-9]:[0-5][0-9]" placeholder="HH:MM:SS" step='1' value="{{ $exercice->time }}">
            </div>

            <div class="value level">
            <select name="level">
                <option disabled>Select Level</option>
                <option value="facile" @if($exercice->level == "facile") selected @endif>Facile</option>
                <option value="intermédiaire" @if($exercice->level == "intermédiaire") selected @endif>Intermédiaire</option>
                <option value="difficile" @if($exercice->level == "difficile") selected @endif>Difficile</option>
            </select>
            </div>


            <div class="value instructions">
                <label for="instructions">Instructions :</label>
                <textarea class="instructions update" id="instructions" name="instructions" placeholder="Soulever la barre des hanches aux épaules...">{{ $exercice->instructions }}</textarea>
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

            <div class="btn-block">
                <button type="submit" class="btn-submit" aria-label="Bouton de validation de l'exercice">Modifier</button>
            </div>
        </form>
    </section>
</main>
</body>
</html>
