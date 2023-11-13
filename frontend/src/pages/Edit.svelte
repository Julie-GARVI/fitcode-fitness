<script>

  window.scrollTo(0, 0);

  let icons = [];
  let exercice = [];
  let exerciceId = '';
  import { push } from "svelte-spa-router";
  export let name, time, instructions, category_id;
  import endpoint from '../storage.js';
 
  
  async function getIconsData() {
    try {
      const response = await fetch(`${endpoint}/multimedias`, {
        method: 'GET',
        headers: {
        'Authorization' : `Bearer ${localStorage.getItem('accessToken')}`,	
        'Content-Type': 'application/json'
        },
      });
    
      if (response.ok) {
      icons = await response.json(); 
      } else {
        console.error("Erreur lors de la récupération des données des catégories");
      }
    } catch (error) {
      console.error("Une erreur s'est produite:", error);
    }
    
  }
    getIconsData();
  
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
        category_id: selectedCategory.id,
        name: formData.get('name'),
        time: formData.get('time'),
        instructions: formData.get('instructions')
    };

    console.log(exerciceId);
    console.log(dataObjectForm);

    try {
        const response = await fetch(`${endpoint}/exercices/${id}`, {
            method: 'PUT',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('accessToken')}`,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dataObjectForm)
        });

        if (response.ok) {

            const showSuccess = document.querySelector(".success")
            showSuccess.style.display = "block";
            setTimeout(() => {
                showSuccess.style.display = "none";
            }, 3000);

            formElement.reset()
            push("/profil");

        } else {
            console.error('Erreur lors de la mise à jour de l\'exercice');

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
                  on:click={() => clickCategory(icon.category[0].id)}
                  data-category-id={icon.category[0].id}
                  class:active={icon.category[0].id === exercice.category_id}
                >
                  <img src={'http://127.0.0.1:8000/icons/' + icon.icon_path} class="category-picture" alt={'Icone de ' + icon.category[0].name}>
                  <p>{icon.category[0].name}</p>
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
            <span class="alert-success success">Votre exercice a bien été modifié</span>
            <div class="btn-block">
                <button type="submit" class="btn-submit" aria-label="Modifier mon exercice">Modifier</button>
            </div>
      
    
        </form>
  
    </section>