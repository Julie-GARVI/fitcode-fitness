<script>
import Loading  from "../components/Loading.svelte";
import endpoint from '../storage.js';
import basket from "../assets/images/basket.jpg";

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
        <h2>Mon profil :</h2>
  
        <div class="shoes-block">
          <img src={basket} class="shoes-picture" alt="image de baskets">
        </div>
  
        <div class="profil-items">
          <div class="profil name">
            <p>{member.firstname} {member.lastname}, <span class="age-profil">{member.age} ans</span></p>
          </div>
          <div class="profil email">
            <p>{member.email}</p>
          </div>
          <div class="line"></div>
          <div class="profil level">
            <p>Niveau {member.level}</p>
          </div>
          <div class="profil number">
            <p>N° abonné : {member.number}</p>
          </div>
        </div>
      </div> 
  </section>
{/if}






