<script>
  window.scrollTo(0, 0);

  import CommentsExercice from "../components/CommentsExercice.svelte";
  import Chronometer from "../lib/Chronometer.svelte";
  import endpoint from '../storage.js';
  
  let exerciceId;
  let exercice = ""; 
  
  async function getExerciceCoach(id) {
      try {
          const response = await fetch(`${endpoint}/exercices/coach/${id}`, {
              method: 'GET',
              headers: {
                  'Authorization': `Bearer ${localStorage.getItem('accessToken')}`,
                  'Content-Type': 'application/json'
              },
          });
          console.log(response);
          if (response.ok) {
              exercice = await response.json();
              console.log(exercice);
          } else {
              console.error('Erreur lors de la récupération des données de l\'équipe');
          }
      } catch (error) {
          console.error('Une erreur s\'est produite:', error);
      }
  }
  
  const numberId = window.location.hash.split('/');
  exerciceId = numberId [numberId.length - 1];
      getExerciceCoach(exerciceId);
  
</script>

  {#if exercice !== ""}

  <section class="container-exercice">

    <h1>{exercice.name}</h1>
    <p>Créé par <span>{exercice.user.firstname}</span>, votre coach <span>{exercice.category.name}</span></p>
     
    <div class="media-block">
      <i class="fa-regular fa-circle-play"></i>
      <img src="{'http://127.0.0.1:8000/exercices/' + exercice.multimedia.picture_path}" class="exercice-picture image" alt="Photo de {exercice.name}">
      <div class="gradient-layer">
        <p>Votre exercice en vidéo</p>
      </div>
    </div>
     
      <div class="container-content">
        <h2>Lancez le programme de l'exercice <span>{exercice.name}</span></h2>
  
          <div class="programme-block">
            <div class="programme-content">
              <p>Catégorie :</p>
              <p>Niveau :</p>
              <p>Temps :</p>  
            </div>
            
            <div class="programme-items">
              <p>{exercice.category.name}</p>
              <p>{exercice.level}</p>
              <p>{exercice.time}</p>
            </div>
          </div>
  
          <div class="instructions-programme">
            <h3>Instructions :</h3>
            <p>{exercice.instructions}</p>
        </div>
  
  </section>

  <section class="wrapper-comments">
        <div class="exercice-challenge">
          <Chronometer /> 
          
          <CommentsExercice 
          exerciceId={exerciceId}
          /> 
        </div>
  </section>

  {/if}