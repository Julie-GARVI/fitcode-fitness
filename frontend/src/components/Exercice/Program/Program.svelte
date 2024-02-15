<script>
   export let name, user, category, level, multimedia, time, instructions, isCoachsPage; 

    import './program.scss'

</script>

<section class="container-exercice">

    <h1>{name}</h1>
    <p>Créé par <span>{user}</span>
        
    {#if isCoachsPage}
    , votre coach <span>{category}</span>
    {/if}</p>
     
    <div class="media-block">
      <i class="fa-regular fa-circle-play"></i>

      {#if isCoachsPage}
      <img src={`http://127.0.0.1:8000/exercices/${multimedia}`} class="exercice-picture image" alt={`Photo de ${name}`}>
      {:else}
      <img src={`http://127.0.0.1:8000/assets/${multimedia}`} class="shoes-picture" alt="baskets">
    {/if}

      <div class="gradient-layer">
        <p>Votre exercice en vidéo</p>
      </div>
    </div>
     
    <div class="container-content">
        <h2>Lancez le programme de l'exercice <span>{name}</span></h2>
  
          <div class="programme-block">
            <div class="programme-content">
              <p>Catégorie :</p>
              {#if isCoachsPage}
              <p>Niveau :</p>
              {/if}
              <p>Temps :</p>  
            </div>
            
            <div class="programme-items">
              <p>{category}</p>
              {#if isCoachsPage}
              <p>{level}</p>
              {/if}
              <p>{time}</p>
            </div>
          </div>
  
          <div class="instructions-programme">
            <h3>Instructions :</h3>
            <p>{instructions}</p>
        </div>
    </div>
</section>
  
