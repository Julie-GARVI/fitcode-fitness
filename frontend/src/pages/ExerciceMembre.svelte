<script>
  window.scrollTo(0, 0);
  
  import Chronometer from "../components/Chronometer.svelte";
  import basket from "../assets/images/basket.jpg";
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

  {#if exercice !== ""}

  <section class="container-exercice">

    <h1>{exercice.name}</h1>

    
        <div class="media-block">
          <i class="fa-regular fa-circle-play"></i>
          <img src={basket} class="shoes-picture" alt="image de baskets">
          <div class="gradient-layer">
            <p>Mon exercice en vidéo</p>
          </div>
        </div>
     
      <div class="container-content">
        <h2>Lancez le programme de l'exercice <span>{exercice.name}</span></h2>
  
          <div class="programme-block">
            <div class="programme-content">
              <p>Temps :</p>
            </div>
            
            <div class="programme-items">
              <p>{exercice.time}</p>
            </div>
          </div>
  
          <div class="instructions-programme">
            <h3>Instructions :</h3>
            <p>{exercice.instructions}</p>
        </div>
  
  
        <div class="exercice-challenge">
          <h2>Chronométrez votre exercice</h2>
          <Chronometer /> 
        </div>
  </section>

  {/if}
