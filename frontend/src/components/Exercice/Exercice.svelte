<script>
    window.scrollTo(0, 0);
  
    import endpoint from '../../storage.js';

    import Program from './Program/Program.svelte'
    import Chronometer from './Chronometer/Chronometer.svelte';
    import Comments from './Comments/Comments.svelte';

    import './exercice.scss'
    
    let exerciceId;
    let exercice = '';

    //const id = exercice.id;
    let isCoachsPage = false;

    
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
                isCoachsPage = true;
                console.log(coachsPage)

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
              isCoachsPage = false;


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
        isCoachsPage={exercice.id >= 1 && exercice.id <= 12}
   
    />

    {/if}

    <section class="wrapper-comments">

        <div class={isCoachsPage === true ? 'exercice-challenge' : ""}>
      
          <Chronometer /> 
    
        {#if isCoachsPage}
          <Comments
            exerciceId={exerciceId}

          />
        {/if}

        </div>

      </section>


  
  
 