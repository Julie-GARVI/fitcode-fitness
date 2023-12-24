<script>
  window.scrollTo(0, 0);

  import ExerciceData from '../data/ExerciceData.svelte';
  import CommentsExercice from "../components/CommentsExercice.svelte";
  import Chronometer from "../lib/Chronometer.svelte";
  import endpoint from '../storage.js';
  
  let exerciceId;
  let exercice = ''; 
  
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

  <ExerciceData 
  name={exercice.name}
  user={exercice.user.firstname}
  multimedia={exercice.multimedia.picture_path}
  category={exercice.category.name}
  level={exercice.level}
  time={exercice.time}
  instructions={exercice.instructions}
  id={exercice.id}
  />

</section>

  {/if}


<section class="wrapper-comments">
  <div class="exercice-challenge">

    <Chronometer /> 
      
    <CommentsExercice 
    exerciceId={exerciceId}
    /> 
  </div>
</section>