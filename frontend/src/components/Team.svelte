<script>
import TeamsData from '../data/TeamsData.svelte';
import endpoint from '../storage.js';

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
      <TeamsData
        lastname={team.lastname}
        firstname={team.firstname}
        age={team.age}
        category={team.category}
        description={team.description}
        multimedia={team.multimedia}
      />
    {/each}

    </div>

