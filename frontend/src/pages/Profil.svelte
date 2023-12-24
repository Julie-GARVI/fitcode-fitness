<script>
  window.scrollTo(0, 0);
  
  import User from "../components/User.svelte"
  import Modal from "../lib/Modal.svelte"
  import ExercicesData from '../data/ExercicesData.svelte';
  import endpoint from '../storage.js';
  import { onMount } from 'svelte';
  
  let exercices = []
  let isContentVisible= ""

//-----------------Récupérer un exercice------------------------- 
      async function getExercicesData() {
        try {
          const dataresponse = await fetch(`${endpoint}/exercices/members`, {
            method: 'GET',
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('accessToken')}`,
              'Content-Type': 'application/json'
            },
          });
      exercices = await dataresponse.json();
      console.log(exercices)
          console.log(dataresponse); 
        } catch (error) {
          console.error('Une erreur s\'est produite:', error);
        }
      }
    getExercicesData()
  


    onMount(() => {
    // Simulez un délai (par exemple, 2 secondes) avant de montrer le contenu
    setTimeout(() => {
      isContentVisible = true;
    }, 2000);
  });

  </script>

  <User exercice={exercices.length} />
  
  <Modal />

  <div class="exercice-event"></div>
  
  <div class="line"></div>
  
  
  <section class="exercices-members-wrapper">
  
      <h2>Mes exercices</h2>
  
        <div class="exercice-container">
          {#each exercices as exercice}
  
          <ExercicesData 
          name={exercice.name}
          category={exercice.category}
          level={exercice.level}
          formatted_time={exercice.formatted_time}
          instructions={exercice.instructions}
          id={exercice.id}
          />
        
      {/each}
        </div>
  </section>