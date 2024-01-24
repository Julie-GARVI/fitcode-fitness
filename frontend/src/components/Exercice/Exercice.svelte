<script>
    window.scrollTo(0, 0);
  
    import endpoint from '../../storage.js';

    import Program from './Program/Program.svelte'
    
    let exerciceId;
    let exercice = ''; 
    
//Exercice d'un coach
    async function getExerciceCoach(id) {
        try {
            const response = await fetch(`${endpoint}/exercices/coach/${id}`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('accessToken')}`,
                    'Content-Type': 'application/json'
                },
            });
            console.log(response);
            if (response.ok) {
                exercice = await response.json();
                console.log(exercice);
            } else {
                console.error('Erreur lors de la récupération des données de l\'équipe');
            }
        } catch (error) {
            console.error('Une erreur s\'est produite:', error);
        }
    }

    //Exercice d'un membre
    async function getExerciceMember(id) {
      try {
          const response = await fetch(`${endpoint}/exercices/member/${id}`, {
              method: 'GET',
              headers: {
                  'Authorization': `Bearer ${localStorage.getItem('accessToken')}`,
                  'Content-Type': 'application/json'
              },
          });
          console.log(response);
          if (response.ok) {
              exercice = await response.json();
              console.log("exerciceId avant l'appel à getExerciceMember :", exerciceId);
              console.log("Réponse de la requête :", response);
              console.log("Données de l'exercice :", exercice);



          } else {
              console.error('Erreur lors de la récupération des données de du membre');
          }
      } catch (error) {
          console.error('Une erreur s\'est produite:', error);
      }
  }
    
    const numberId = window.location.hash.split('/');
    exerciceId = numberId [numberId.length - 1];
        getExerciceCoach(exerciceId);
        getExerciceMember(exerciceId);
    
  </script>
  
  
    {#if exercice !== ""}

        <Program 
        name={exercice.name}
        user={exercice.user.firstname}
        category={exercice.category.name}
        level={exercice.level}
        time={exercice.time}
        multimedia={exercice.multimedia.picture_path}
        instructions={exercice.instructions}
        id={exercice.id} 
    />

    {/if}
  
 