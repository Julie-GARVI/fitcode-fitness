<script>
import endpoint from '/src/storage.js';

import User from './User/User.svelte';
import Loading  from "/src/lib/Loading.svelte";

import '../Users/users.scss'

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

          <User
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






