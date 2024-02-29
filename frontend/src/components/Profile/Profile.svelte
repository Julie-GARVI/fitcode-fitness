<script>
  window.scrollTo(0, 0);
  
  import endpoint from '../../storage.js';
  import { onMount } from 'svelte';

  import Users from "./Users/Users.svelte"
  import Modal from "./Modal/Modal.svelte"
  import Exercices from '../../reusable/Exercices/Exercices.svelte';

  import './profile.scss'
  
  let exercices = []

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

    setTimeout(() => {
      isContentVisible = true;
    }, 2000);
  });

  </script>

  <Users exercice={exercices.length} />
  
  <Modal />

  <div class="exercice-event"></div>
  
  <div class="line"></div>
  
  
  <section class="exercices-members-wrapper">
  
    <h2>Mes exercices</h2>

      <div class="exercice-container">
        {#each exercices as exercice}

        <Exercices 
        name={exercice.name}
        category={exercice.category}
        level={exercice.level}
        formatted_time={exercice.formatted_time}
        instructions={exercice.instructions}
        id={exercice.id}
        user={exercice.user.role}
        />
      
    {/each}
      </div>
</section>