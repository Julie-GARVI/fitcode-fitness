<script>
  window.scrollTo(0, 0);
  
  import ExerciceData from '../data/ExerciceData.svelte';
  import Chronometer from "../lib/Chronometer.svelte";
  import endpoint from '../storage.js';
  
  let exerciceId;
  let exercice = ""; 
  
  async function getExerciceMember(id) {
      try {
          const response = await fetch(`${endpoint}/exercices/member/${id}`, {
              method: 'GET',
              headers: {
                  'Authorization': `Bearer ${localStorage.getItem('accessToken')}`,
                  'Content-Type': 'application/json'
              },
          });
          console.log(response);
          if (response.ok) {
              exercice = await response.json();
              console.log("exerciceId avant l'appel à getExerciceMember :", exerciceId);
              console.log("Réponse de la requête :", response);
              console.log("Données de l'exercice :", exercice);



          } else {
              console.error('Erreur lors de la récupération des données de du membre');
          }
      } catch (error) {
          console.error('Une erreur s\'est produite:', error);
      }
  }
  
  const numberId = window.location.hash.split('/');
  exerciceId = numberId [numberId.length - 1];
      getExerciceMember(exerciceId);
  
</script>

<section class="container-exercice">

  {#if exercice !== ""}

    <ExerciceData 
  name={exercice.name}
  user={exercice.user.firstname}
  category={exercice.category.name}
  level={exercice.level}
  time={exercice.time}
  instructions={exercice.instructions}
  />

  
    <div class="exercice-member">
      <Chronometer /> 
    </div>

    {/if}

  </section>

 
