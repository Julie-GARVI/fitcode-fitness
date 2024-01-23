<script>
    window.scrollTo(0, 0);
  
    import endpoint from '../../storage.js';
    
    let exerciceId;
    let exercice = ''; 
    
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
    
    const numberId = window.location.hash.split('/');
    exerciceId = numberId [numberId.length - 1];
        getExerciceCoach(exerciceId);
    
  </script>
  
    {#if exercice !== ""}
  
    <section class="container-exercice">

  </section>
  
    {/if}
  
  
  <section class="wrapper-comments">
    <div class="exercice-challenge">
  
        <h1>test</h1>
    </div>
  </section>