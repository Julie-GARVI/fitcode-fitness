<script>
  window.scrollTo(0, 0);
  
  import User from "../components/User.svelte"
  import Modal from "../lib/Modal.svelte"
  import basket from "../assets/images/basket.jpg";
  import { link } from "svelte-spa-router";
  import endpoint from '../storage.js';
  import { onMount } from 'svelte';
  export let exercice;
  
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
  


  //-----------------Supprimer un exercice------------------------ 
    async function deleteExercice(id) {
  
      try {
          const dataresponse = await fetch(`${endpoint}/exercices/${id}`, {
          method: 'DELETE',
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('accessToken')}`,
            'Content-Type': 'application/json'
          },
        });
        const message = await dataresponse.json();
        console.log(message)
  
        const exerciceDelete = document.querySelector('#card-'+id);
        console.log(exerciceDelete)
        exerciceDelete.remove();
  
        } catch (error) {
        console.error('Une erreur s\'est produite:', error);
      }
    }

    onMount(() => {
    // Simulez un délai (par exemple, 2 secondes) avant de montrer le contenu
    setTimeout(() => {
      isContentVisible = true;
    }, 2000);
  });

  </script>

  <User exercice={exercices.length} />
  
  <Modal 
  name="name"
  category_id="category-id"
  time="time"
  instructions="instructions"
  />

  <div class="exercice-event"></div>
  
  <div class="line"></div>
  
  
  <section class="exercices-members-wrapper">
  
      <h2>Mes exercices</h2>
  
        <div class="exercice-container">
          {#each exercices as exercice}
  
              <div class="block-exercice" id="card-{exercice.id}">
  
                <div class="exercice-name">
                  <h3>{exercice.name}</h3>
                </div>
  
                <div class="img-block">
                  <img src={basket} class="shoes-picture" alt="Image de baskets" role="presentation">
                </div>
  
                <div class="exercice-content">
                    {#if exercice.category}
                      <p>{exercice.category.name}</p>
                    {/if}
            
                    <!-- <p>{exercice.time}</p> -->
                    <p>{exercice.formatted_time}</p>
            
                    <div class="exercice-instruction">
                      <p>{exercice.instructions}</p>
                    </div>
                </div>
  
                <div class="btn-crud">
                    <div class="btn-submit">
                      <button class="btn-link" type="submit"><a use:link href="/exercice/membre/{exercice.id}">Démarrer</a></button>
                    </div>
                  
                    <div class="btn-items">
                        <a href="/exercices/membre/edit/{exercice.id}" aria-label="Aller à la page exercice" use:link><button class="btn-create"id="buttonEdit"><i class="fa-solid fa-pen"></i></button></a>		 
                        <button on:click={deleteExercice(exercice.id)} class="btn-create"id="buttonDelete"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
        </div>
      {/each}
        </div>
  </section>