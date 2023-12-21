<script>
import Loading  from "../components/Loading.svelte";
import endpoint from '../storage.js';
import woman from "../assets/images/exercices.jpg";
import man from "../assets/images/man.jpg";

let member = []
let isLoading = true;
let activeClass = '';
export let exercice;
let profilWrapper;

//----------------Récupération de l'utilisateur-----------------
async function getMemberData(id) {
       try {
         const dataresponse = await fetch(`${endpoint}/members/${id}`, {
           method: 'GET',
           headers: {
             'Authorization': `Bearer ${localStorage.getItem('accessToken')}`,
             'Content-Type': 'application/json'
           },
         });
     member = await dataresponse.json();
     console.log(member)
     console.log(dataresponse);

     isLoading = false;
     !isLoading ?  setTimeout(() => {
     activeClass = 'active';
   }, 100) 
   : activeClass = "";

       } catch (error) {
         console.error('Une erreur s\'est produite:', error);
       }
     }
 getMemberData(localStorage.getItem("id"))


</script>

{#if isLoading}
  <Loading />
  {:else}

<section  bind:this={profilWrapper} class={`profil-wrapper ${activeClass}`}>
  
    <h1>Bonjour <span class="blue-title">{member.firstname}</span></h1>
    <h2>Bienvenue sur votre espace membre</h2>
  
      <div class="profil-container">  
  
        <div class="profil-items">

          <div class="profil-block">

            {#if member.gender === 'Femme'} 
            <img src={woman} class="profil-picture" alt="femme">
            {/if}

            {#if member.gender === 'Homme'} 
            <img src={man} class="profil-picture" alt="homme">
            {/if}

          </div>

            <div class="profil-row1">
                <div class="profil name">
                    <h2>{member.firstname} {member.lastname}, <span class="age-profil">{member.age} ans</span></h2>
                </div>
                <div class="profil email">
                    <p><i class="fa-solid fa-paper-plane pink"></i> {member.email}</p>
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
                  <p>{member.level}</p>
                </div>
              </div>
      
              <div class="profil number">
                <div class="icon-block">
                  <i class="fa-regular fa-user fa-lg"></i>
                  <p> Membre : n°{member.number}</p>
                </div>
              </div>

            </div>

        </div>

      </div> 

  </section>
{/if}






