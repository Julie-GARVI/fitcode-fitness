<script>

  import basket from "/src/assets/images/basket.webp";
  
  export let name, user, category, multimedia, level, time, instructions, id;
 
</script>

    <h1>{name}</h1>
    <p>Créé par <span>{user}</span>
        
    {#if id >= 1 && id <= 12}
    , votre coach <span>{category}</span>
    {/if}</p>
     
    <div class="media-block">
      <i class="fa-regular fa-circle-play"></i>

      {#if id >= 1 && id <= 12}
        <img src="{'http://127.0.0.1:8000/exercices/' + multimedia}" class="exercice-picture image" alt="Photo de {name}">
      {:else}
        <img src={basket} class="shoes-picture" alt="Image de baskets">
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
              {#if id >= 1 && id <= 12}
              <p>Niveau :</p>
              {/if}
              <p>Temps :</p>  
            </div>
            
            <div class="programme-items">
              <p>{category}</p>
              {#if id >= 1 && id <= 12}
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
  


  