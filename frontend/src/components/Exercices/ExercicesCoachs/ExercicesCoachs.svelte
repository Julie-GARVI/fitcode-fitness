<script>
	import endpoint from '../storage.js';

	import ExercicesData from '../data/ExercicesData.svelte';

	import '../ExercicesCoachs/exercicesCoachs.scss'

	let allExercices = []; 
	let exercices = []; 
	let filterCategory = "";
	let filterLevel = "";

	const category_status = [
		{ name: "Musculation", id: 1 },
		{ name: "Yoga", id: 2 },
		{ name: "Aquagym", id: 3 },
		{ name: "Cardio", id: 4 },
		{ name: "Toutes les catégories", id: "" }
	];

	const level_status = ["Facile", "Intermédiaire", "Difficile"];

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

//Fonction permettrant le filtrage d'un exercice par sa catégorie
	const filterCategoryExercices = () => {
//Affiche tous les exercices par défaut
		if (filterCategory === "") {
			exercices = [...allExercices]; 
		} else {
//Sinon retrouve l'exercice par l'id de sa catégorie
			exercices = allExercices.filter(exercice => exercice.category_id === filterCategory);
		}
	}

	const filterLevelExercices = () => {
	if (filterLevel === "Tous les niveaux") {
		// Si "Tous les niveaux" sont sélectionnés, afficher tous les exercices
		exercices = [...allExercices]; // Réinitialiser la liste des exercices
	} else {
		// Sinon, filtrer les exercices en fonction du niveau
		exercices = allExercices.filter(exercice => exercice.level === filterLevel);
	}
}
</script>

  
<h2>Nos exercices sur-mesure</h2>

<div class="exercices-private">
	<i class="fa-regular fa-user"></i>
	<h3>Conçus par vos coachs</h3>
</div>

<div class="filter-container">
	<div class="filter-block">
		<select bind:value={filterCategory} on:change={filterCategoryExercices} aria-label="Selectionner votre catégorie" class="filter-category">
			{#each category_status as category}
				<option value={category.id}>{category.name}</option>
			{/each}
		</select>
	</div>

	<div class="filter-block">
		<select bind:value={filterLevel} on:change={filterLevelExercices} aria-label="Selectionner votre niveau" class="filter-level">
			<option value="" disabled selected>Votre niveau</option>
			{#each level_status as status}
				<option value={status}>{status}</option>
			{/each}
			<option>Tous les niveaux</option>
		</select>
	</div>
</div>


<!-- Affichage de tous les exercices à l'aide d'une boucle -->
<div class="exercice-container">
	{#each exercices as exercice}
		
	<ExercicesData 
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