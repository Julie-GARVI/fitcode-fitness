<script>
    import { link } from "svelte-spa-router";
    import endpoint from '../../storage.js';

    import '../Exercices/exercices.scss'

    import basket from "../assets/images/basket.webp";

    export let name, category, multimedia, level, formatted_time, instructions, id;
 
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
  
</script>

<div class="block-exercice" id="card-{id}">
    <div class="exercice-name">
        <h3>{name}</h3>
</div>
    
{#if id >= 1 && id <= 12}
 <div class="img-block">
    <img src={'http://127.0.0.1:8000/exercices/' + multimedia} class="exercice-picture" alt={'Photo de ' + name}>
</div>
{:else}
<div class="img-block">
    <img src={basket} class="shoes-picture" alt="Image de baskets">
</div>
{/if}
      
<div class="exercice-category">
    <p>{category.name}</p>
</div>

<div class="exercice-content">
    {#if id >= 1 && id <= 12}
        <span><p>{level}</p></span>
    {/if}
    <p>Durée : {formatted_time}</p>
    <div class="exercice-instruction">
        <p>{instructions}</p>
    </div>
</div>

{#if id >= 1 && id <= 12}
    <div class="btn-submit">
        <button class="btn-link" type="submit"><a use:link href="/exercice/coach/{id}">Démarrer</a></button>
    </div>
{:else}

<div class="btn-crud">
    <div class="btn-submit">
        <button class="btn-link" type="submit"><a use:link href="/exercice/membre/{id}">Démarrer</a></button>
    </div>
      
    <div class="btn-items">
        <a href="/exercices/membre/edit/{id}" aria-label="Aller à la page exercice" use:link><button class="btn-create"id="buttonEdit"><i class="fa-solid fa-pen"></i></button></a>		 
            <button on:click={deleteExercice(id)} class="btn-create"id="buttonDelete"><i class="fa-solid fa-trash"></i></button>
        </div>
    </div>
{/if}
</div>
	
