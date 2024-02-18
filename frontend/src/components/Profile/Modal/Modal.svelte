<script>

import endpoint from '../../../storage.js';
import { onMount } from 'svelte';

import { getIconsData } from "../../../reusable/getIconData.js"

import '../Modal/modal.scss'

import basket from "/src/assets/images/basket.webp";

let name, category_id, time, formattedTime, instructions;

let icons = [];

//------------Récupération des icones--------------------------
onMount(async () => {
        try {
        icons = await getIconsData();
        console.log(icons);
        } catch (error) {
        console.error("An error occurred:", error);
        }
    });
  

 //-----------------Ouvrir et fermer la modale-------------------------
 function openModal() {
      const openForm = document.querySelector(".form-crud");
      console.log(openForm);
      openForm.style.display = "block";
    }
  
    function closeModal() {
      const closeForm = document.querySelector(".form-crud");
      console.log(closeForm);
      closeForm.style.display = "none";
    }
  

 //-----------------Selectionner les catégories------------------------- 
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

  //-----------------Ajouter un exercice------------------------- 
async function addExerciceUser() {
  try {
    const exerciceResponse = await fetch(
      `${endpoint}/exercices`,
      {
        method: "POST",
        headers: {
          Authorization: `Bearer ${localStorage.getItem("accessToken")}`,
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          name,
          category_id,
          time,
          instructions,
        }),
      }
    );

    if (exerciceResponse.ok) {
      const responseData = await exerciceResponse.json();
      console.log(responseData);

      const addExerciceInDom = document.querySelector(".exercice-event");

      //Création des éléments
      const addMainBlock = document.createElement("div");
      addMainBlock.classList.add("block-exercice");
      addExerciceInDom.append(addMainBlock);
      addExerciceInDom.style.display = "block";


      //Le nom des exercices
          const addBlockName = document.createElement("div");
          addBlockName.classList.add("exercice-name");
          addMainBlock.append(addBlockName);

      //Le titre des exercices
            const addName = document.createElement("h2")
            addName.textContent = responseData.name;
            addBlockName.append(addName);

      //L'image de profil'
              const addPicture = document.createElement("img");
              addPicture.classList.add("shoes-picture");
              addPicture.src = basket;
              addPicture.alt = "Photo d'une basket";
              addMainBlock.append(addPicture);

      //Le contenu des exercices
        const addContentBlock = document.createElement("div");
        addContentBlock.classList.add("exercice-content");
        addMainBlock.append(addContentBlock);

      
      //L'id de l'exercice correspond au bouton
          const categoriesData = [
            { id: 1, name: "Musculation" },
            { id: 2, name: "Yoga" },
            { id: 3, name: "Aquagym" },
            { id: 4, name: "Cardio" }
        ];

          const selectedCategory = categoriesData.find(category => category.id === category_id);

      //la catégorie d'exercice
            const addCategory = document.createElement("p");
            addCategory.textContent = selectedCategory.name;
            addContentBlock.append(addCategory);

      //le contenu des exercices
      const addBlockInstructions = document.createElement("div");
      addBlockInstructions.classList.add("exercice-instruction"); 
      addContentBlock.append(addBlockInstructions);

          const addInstructions = document.createElement("p");
          addInstructions.textContent = responseData.instructions;
          addBlockInstructions.append(addInstructions);

        const form = document.querySelector(".form-crud");

      const showSuccess = document.querySelector(".success");
      showSuccess.style.display = "block";
      setTimeout(() => {
        showSuccess.style.display = "none";
        
        setTimeout(() => {
          location.reload();
        }, 2500);

      }, 2500);
   
      form.reset();
     

    } else {
      console.log("Échec de la requête.", exerciceResponse.status);
    }
  } catch (error) {
    console.log("Une erreur s'est produite : " + error.message);
  }
}


</script>

<section class="modal-wrapper">
  
    <div class="exercice-crud">
      <button class="btn-open" aria-label="Ouvrir la modale" on:click={openModal}><i class="fa-solid fa-plus fa-xl"></i><br> Nouvel exercice</button>
    </div>
  
      <form class="form-crud" on:submit|preventDefault={addExerciceUser}>
  
        <i class="fa-solid fa-xmark fa-xl" aria-label="Fermer la modale" type="button" on:click={closeModal}></i>
        
        <div class="value categories">
          <label for="categories">Selectionner votre catégorie :</label>
          <div class="select-block">
              {#each icons as icon}
              <button type="button" class="category-item" on:click={() => clickCategory(icon.category.id)}>
                      <img src={'http://127.0.0.1:8000/icons/' + icon.icon_path} class="category-picture" alt={'Icone de ' + icon.category.name}>
                      <p>{icon.category.name}</p>
                  </button>
              {/each}
          </div>
        </div>

        <span class="empty-alert alert">Erreur, un champ est vide</span>

        <span class="name alert">Erreur ! Le nom de l'exercice ne doit pas contenir de caractères particuliers</span>

          <div class="value name">
            <label for="name">Nom de l'exercice :</label>
            <input type="text" id="name" name="name" class="name create" placeholder="Développé militaire" bind:value={name}>
          </div>

          <div class="value time">
            <label for="time">Durée de l'exercice (heure:minutes:secondes) :</label>
            <input type="time" id="time" class="time create" name="time" pattern="[0-5][0-9]:[0-5][0-9]" placeholder="HH:MM:SS" step='1' bind:value={time}>
          </div>
          
          <span class="instructions alert">Erreur ! Les instructions de l'exercice ne doivent pas contenir de caractères particuliers</span>
          <div class="value instructions">
              <label for="instructions">Vos instructions :</label>
              <textarea class="instructions create" id="instructions" name="instructions" placeholder="Soulever la barre des hanches aux épaules..." bind:value={instructions}></textarea>
          </div>
  
          <div class="btn-block">
              <span class="alert-success success">Votre exercice a bien été ajouté</span>
              <button type="submit" class="btn-submit" aria-label="Bouton de validation de l'exercice">Valider</button>
          </div>
  
      </form>

</section>