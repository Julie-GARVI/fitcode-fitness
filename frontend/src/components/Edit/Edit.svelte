<script>

  window.scrollTo(0, 0);

  import { onMount } from 'svelte';
  import { push } from "svelte-spa-router";
  import endpoint from '../../storage.js';

  import { getIconsData } from "../../reusable/getIconData.js"
  import ErrorsMessages from "../../reusable/ErrorsMessages.svelte";

  import './edit.scss'

  let icons = [];
  let exercice = [];
  let exerciceId = '';
  
  let category_id;

  let errorMessages = []; 
  let displayError = false;
  let displayDuration = 5000;

  onMount(async () => {
        try {
        icons = await getIconsData();
        console.log(icons);
        } catch (error) {
        console.error("An error occurred:", error);
        }
    });
  
    function clickCategory(id) {
    const selectCategory = document.querySelectorAll(".category-item");
    
    selectCategory.forEach((item) => {
      item.addEventListener("click", () => {
        selectCategory.forEach((otherItem) => {
          otherItem.classList.remove("active");
        });
        item.classList.add("active");
  
        category_id = id;
      });
    });
  }
  
  async function getExercicesData(id) {
      try {
        const dataresponse = await fetch(`${endpoint}/exercices/member/${id}`, {
          method: 'GET',
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('accessToken')}`,
            'Content-Type': 'application/json'
          },
        });
        if (dataresponse.ok) {
          exercice = await dataresponse.json();
          category_id = exercice.category_id; 
        } else {
          console.error("Erreur lors de la récupération des données de l'exercice");
        }
      } catch (error) {
        console.error("Une erreur s'est produite:", error);
      }
    }
  
    const numberId = window.location.hash.split('/');
    exerciceId = numberId [numberId.length - 1];
    getExercicesData(exerciceId);
  
  
    //----------------------------Fonction permettant de modifier un exercice----------------------------------------
    async function editExercicesData(id) {
    const formElement = document.querySelector("form");
    const formData = new FormData(formElement);

    // L'id de l'exercice correspond au bouton
    const categoriesData = [
        { id: 1, name: "Musculation" },
        { id: 2, name: "Yoga" },
        { id: 3, name: "Aquagym" },
        { id: 4, name: "Cardio" }
    ];

    const selectedCategory = categoriesData.find(category => category.id === category_id);

    console.log(selectedCategory);

    const dataObjectForm = {
        name: formData.get('name'),
        time: formData.get('time'),
        instructions: formData.get('instructions')
    };

    if (selectedCategory) {
        dataObjectForm.category_id = selectedCategory.id;
    }

    try {
        const response = await fetch(`${endpoint}/exercices/${id}`, {
            method: 'PUT',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('accessToken')}`,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dataObjectForm)
        });

        const responseData = await response.json();

        if (response.ok) {
          
            formElement.reset()
            push("/profil");

        } else {
          errorMessages = responseData.errors;

          displayError = true;

          setTimeout(() => { 
              displayError = false;
            }, displayDuration);
          }
    } catch (error) {
        console.error('Une erreur s\'est produite:', error);
    }
  }
  </script>
  
    <section class="edit-exercices">
  
        <h2>Modifiez votre exercice</h2>
  
        <form class="form-crud" on:submit|preventDefault={() => editExercicesData(exercice.id)}>
  
          <div class="value categories">
            <label for="categories">Modifier votre catégorie :</label>
            <div class="select-block">
              {#each icons as icon}
                <button
                  type="button"
                  class="category-item"
                  on:click={() => clickCategory(icon.category.id)}
                  data-category-id={icon.category.id}
                  class:active={icon.category.id === exercice.category_id}
                >
                  <img src={'http://127.0.0.1:8000/icons/' + icon.icon_path} class="category-picture" alt={'Icone de ' + icon.category.name}>
                  <p>{icon.category.name}</p>
                </button>
              {/each}
            </div>
          </div>
          
  
          <span class="empty-alert alert">Erreur, un champs est vide</span>
  
            <div class="value name">
              <label for="name">Modifier le nom de l'exercice :</label>
              <input type="text" id="name" name="name" class="name edit" value={exercice.name}>
            </div>

            <div class="value time">
              <label for="time">Modifier votre temps (heure:minutes:secondes) :</label>
              <input type="time" id="name" class="time create" name="time" pattern="[0-5][0-9]:[0-5][0-9]" placeholder="HH:MM:SS" step='1' value={exercice.time}>
            </div>

    
            <div class="value instructions">
                <label for="instructions">Modifier vos instructions :</label>
                <textarea class="instructions edit" id="instructions"  name="instructions" value={exercice.instructions}></textarea>
            </div>

            <ErrorsMessages 
            errorMessages= {errorMessages}
            displayError= {displayError}
            />

            <div class="btn-block">
                <button type="submit" class="btn-submit" aria-label="Modifier mon exercice">Modifier</button>
            </div>
      
    
        </form>
  
    </section>