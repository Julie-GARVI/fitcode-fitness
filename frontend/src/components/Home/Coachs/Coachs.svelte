<script>
import endpoint from '/src/storage.js';

import Coach from './Coach/Coach.svelte';

import './coachs.scss'

let teams = []; 

async function getTeamData() {

  try {
    const response = await fetch(`${endpoint}/teams`,);
  
    if (response.ok) {
      teams = await response.json(); 
      console.log(response)
    } else {
      console.error("Erreur lors de la récupération des données de l'équipe");
    }
  } catch (error) {
    console.error("Une erreur s'est produite:", error);
  }
  
}
getTeamData() 

</script>

<h2>Notre équipe</h2>

  <div class="teams-container">

    {#each teams as team}
      <Coach
        lastname={team.lastname}
        firstname={team.firstname}
        age={team.age}
        categories={team.categories}
        description={team.description}
        multimedia={team.multimedia}
      />
    {/each}

  </div>

