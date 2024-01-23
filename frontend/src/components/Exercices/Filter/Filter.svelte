<script>
    import { createEventDispatcher } from "svelte";

	import './filter.scss'

    const category_status = [
        { name: "Musculation", id: 1 },
        { name: "Yoga", id: 2 },
        { name: "Aquagym", id: 3 },
        { name: "Cardio", id: 4 },
        { name: "Toutes les catégories", id: "" }
    ];

    const level_status = ["Facile", "Intermédiaire", "Difficile"];

	let filterCategory = "";
    let filterLevel = "";

  //Filtrage
  const dispatch = createEventDispatcher();

  function filterCategoryChange() {
    dispatch('filterCategoryChange', { filterCategory });
  }

  function filterLevelChange() {
    dispatch('filterLevelChange', { filterLevel });
  }

</script>

<section class="exercices-list">
  
	<h2>Nos exercices sur-mesure</h2>

	<div class="exercices-private">
		<i class="fa-regular fa-user"></i>
		<h3>Conçus par vos coachs</h3>
	</div>

	<div class="filter-container">
		<div class="filter-block">
			<select bind:value={filterCategory} on:change={filterCategoryChange} aria-label="Selectionner votre catégorie" class="filter-category">
				{#each category_status as category}
					<option value={category.id}>{category.name}</option>
				{/each}
			</select>
		</div>

		<div class="filter-block">
			<select bind:value={filterLevel} on:change={filterLevelChange} aria-label="Selectionner votre niveau" class="filter-level">
				<option value="" disabled selected>Votre niveau</option>
				{#each level_status as status}
					<option value={status}>{status}</option>
				{/each}
				<option>Tous les niveaux</option>
			</select>
		</div>
	</div>
</section>

