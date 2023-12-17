<script>
import Loading  from "../components/Loading.svelte";
import endpoint from '../storage.js';
import chat from "../assets/images/chat.jpg";

let member = []
let isLoading = true;
let activeClass = '';

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

<section class={`profil-wrapper ${activeClass}`}>
  
    <h1>Bonjour <span class="blue-title">{member.firstname}</span></h1>
    <h2>Bienvenue sur votre espace membre</h2>
  
      <div class="profil-container">  
        <div class="profil-block">
          <img src={chat} class="profil-picture" alt="image de baskets">
        </div>
  
        <div class="profil-items">

            <div class="profil-row1">
                <div class="profil name">
                    <h2>{member.firstname} {member.lastname}, <span class="age-profil">{member.age} ans</span></h2>
                </div>
                <div class="profil email">
                    <p>{member.email}</p>
                </div>
            </div>
            
            <div class="profil-row2">
                <div class="profil exercice-number">
                    <p>5 exercices</p>
                </div>
                <div class="profil level">
                    <p>Niveau {member.level}</p>
                </div>
                <div class="profil number">
                    <p>N° abonné : {member.number}</p>
                </div>
            </div>

        </div>

      </div> 

  </section>
{/if}






