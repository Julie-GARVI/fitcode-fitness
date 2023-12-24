<script>
import Loading  from "../lib/Loading.svelte";
import endpoint from '../storage.js';
import UserData from '../data/UserData.svelte';

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

          <UserData 
          gender={member.gender}
          firstname={member.firstname}
          lastname={member.lastname}
          age={member.age}
          email={member.email}
          exercice={exercice}
          level={member.level}
          number={member.number}
          />

        </div>

      </div> 

  </section>
{/if}






