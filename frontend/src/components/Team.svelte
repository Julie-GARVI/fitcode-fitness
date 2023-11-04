<script>
    export let lastname, firstname, age, category, description, multimedia;
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
        <div class="teams-content">

            <div class="teams-img">
              <img src={'http://127.0.0.1:8000/coachs/' + team.multimedia.picture_path} class="coachs-picture" alt="Photo de {team.firstname} {team.lastname}">
            </div>

            <div class="teams-name">
            <p><span>{team.firstname} {team.lastname}</span></p>
		        <p>{team.age} ans</p>
            </div>

            <div class="teams-category">
              <img src={'http://127.0.0.1:8000/icons/' + team.multimedia.icon_path} class="category-icon" alt="Icone de {team.category.name}">
              <p>{team.category.name}</p>
            </div>

            <div class="teams-description">
                <p>{team.description}</p>
            </div>

        </div>
        {/each}

    </div>

