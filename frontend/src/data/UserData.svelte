<script>
    export let gender, firstname, lastname, age, email, exercice, level, number;
    import woman from "../assets/images/woman.webp";
    import man from "../assets/images/man.webp";
</script>

<div class="profil-block">
    {#if gender === 'Femme'} 
        <img src={woman} class="profil-picture" alt="femme">
    {/if}

    {#if gender === 'Homme'} 
        <img src={man} class="profil-picture" alt="homme">
    {/if}
</div>

<div class="profil-row1">
    <div class="profil name">
         <h2>{firstname} {lastname}, <span class="age-profil">{age} ans</span></h2>
    </div>
    <div class="profil email">
        <p><i class="fa-solid fa-paper-plane pink"></i> {email}</p>
    </div>
</div>


<div class="profil-row2">
    <div class="profil exercice-number">
      <div class="icon-block">
        <i class="fa-solid fa-person-running fa-xl"></i>

      {#if exercice > 1}
        <p><span class="counter">{exercice}</span> exercices</p>
      {:else}
      <p><span class="counter">{exercice}</span> exercice</p>
      {/if}
      </div>

    </div>

    <div class="profil level">
      <div class="icon-block">
        <i class="fa-solid fa-medal fa-lg"></i>
        <p>{level}</p>
      </div>
    </div>

    <div class="profil number">
      <div class="icon-block">
        <i class="fa-regular fa-user fa-lg"></i>
        <p> Membre : n°{number}</p>
      </div>
    </div>
  </div>