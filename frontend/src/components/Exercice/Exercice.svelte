<script>
    window.scrollTo(0, 0);
  
    import endpoint from '../../storage.js';

    import Program from './Program/Program.svelte'
    import Chronometer from './Chronometer/Chronometer.svelte';
    import Comments from './Comments/Comments.svelte';

    import './exercice.scss'
    

    let exercice = '';
    //const id = exercice.id;
    let role = "";

    export let params = {};


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
        //console.log(response);

        exercice = await response.json();
        //console.log(exercice);

        if (response.ok) {
            console.log(exercice.user.role);
            role = exercice.user.role; 
            
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

          exercice = await response.json();
          
          if (response.ok) {
              console.log("Réponse de la requête :", response);
              console.log("Données de l'exercice :", exercice);
          }

        } catch (error) {
            console.error('Une erreur s\'est produite:', error);
      }
  }
        getExerciceCoach(params.id);
        getExerciceMember(params.id);

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
        isCoachsPage={exercice.user.role === "Admin"}
   
    />

    {/if}

    <section class="wrapper-comments">

        <div class={role === "Admin" ? 'exercice-challenge' : ""}>
      
          <Chronometer /> 
    
        {#if role === "Admin"}
          <Comments
            exerciceId={params.id}

          />
        {/if}

        </div>

    </section>


  
  
 