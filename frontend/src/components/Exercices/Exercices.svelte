<script>
    window.scrollTo(0, 0);

    import { onMount } from 'svelte';
    import endpoint from "/src/storage.js";
    
    import { getIconsData } from "../../reusable/getIconData.js"

    import Filter from "./Filter/Filter.svelte";
    import Exercices from '/src/reusable/Exercices/Exercices.svelte'

    import './exercices.scss'

    import background from "../../assets/images/exercices.webp";

    //const dispatch = createEventDispatcher();

    let icons = [];
    export let exercices = [];

    let allExercices = [];

    onMount(async () => {
        try {
        icons = await getIconsData();
        console.log(icons);
        } catch (error) {
        console.error("An error occurred:", error);
        }
    });

        //Requête permettant la récupération des exercices des coachs
	async function getExercicesData() {
		try {
//Requête API
			const response = await fetch(`${endpoint}/exercices/coachs`, {
				method: 'GET',
				headers: {
//Autorisation du token pour identifier la personne qui accède à l'éxercice
					'Authorization' : `Bearer ${localStorage.getItem('accessToken')}`,  
					'Content-Type': 'application/json'
				},
			});
			console.log(response);
			if (response.ok) {
				allExercices = await response.json();
//Utilisation d'un spread operator
				exercices = [...allExercices]; 
				console.log(exercices);
			} else {
				console.error('Erreur lors de la récupération des données de l\'équipe');
			}
		} catch (error) {
			console.error('Une erreur s\'est produite:', error);
		}
	}
	getExercicesData();

    function handleFilterChange(event) {
    const { filterCategory, filterLevel } = event.detail;
    if (filterCategory !== undefined) {
      filterCategoryExercices(filterCategory);
    }
    if (filterLevel !== undefined) {
      filterLevelExercices(filterLevel);
    }
  }

  function filterCategoryExercices(selectedCategory) {
    if (selectedCategory === "") {
      exercices = [...allExercices];

    } else {
      exercices = allExercices.filter(exercice => exercice.category_id === selectedCategory);
    }
  }

  function filterLevelExercices(selectedLevel) {
    if (selectedLevel === "Tous les niveaux") {
      exercices = [...allExercices];

    } else {
      exercices = allExercices.filter(exercice => exercice.level === selectedLevel);
    }
  }

</script>
    
    <div class="wrapper-exercices">
    
        <div class="background-exercice">
            <img src="{background}" alt="Adhérente">
        </div>
    
        <section class="fitness-exercices">
    
                <div class="exercice-select">
                    <h2>Choisissez votre exercice</h2>
    
                    <div class="block-items">
                        <div class="items">
                            <i class="fa-regular fa-heart"></i>
                            <h3>Par catégorie</h3>
                        </div>
                    </div>
    
                    <div class="select-block">
                    {#each icons as icon}
                        <div class="category-item">
                            <img src={'http://127.0.0.1:8000/icons/' + icon.icon_path} class="category-picture" alt={'Icone de ' + icon.category.name}>
                            <p>{icon.category.name}</p>
                        </div>
                    {/each}
                    </div>
    
                    <div class="block-items">
                        <div class="items">
                            <i class="fa-solid fa-medal"></i>
                            <h3>Par niveau</h3>
                        </div>
                    </div>
    
                    <div class="select-option" aria-label="selectionner son niveau">
                        <div class="select debutant" aria-label="niveau débutant">
                            <p>Débutant</p>
                        </div>
                        <div class="select intermédiaire" aria-label="niveau intermédiaire">
                            <p>Intermédiaire</p>
                        </div>
                        <div class="select avancé" aria-label="niveau avancé">
                            <p>Avancé</p>
                        </div>
                    </div> 
                </div>   
        </section>

        <Filter 
        on:filterCategoryChange={handleFilterChange}
        on:filterLevelChange={handleFilterChange} />

          <!-- Affichage de tous les exercices à l'aide d'une boucle -->
          <div class="exercice-container --coach">
            {#each exercices as exercice}
                
            <Exercices
            name={exercice.name}
            category={exercice.category}
            level={exercice.level}
            formatted_time={exercice.formatted_time}
            instructions={exercice.instructions}
            multimedia={exercice.multimedia.picture_path}
            id={exercice.id}
      
            />

            {/each}
        </div>
    </div>

          
