<script>
  window.scrollTo(0, 0);

  import { link, push } from "svelte-spa-router";
  import endpoint, { isAuthenticated } from "/src/storage.js";
    
  import Coachs from "./Coachs/Coachs.svelte";
  import Comments from "./Comments/Comments.svelte";

  import ErrorsMessages from "../../reusable/ErrorsMessages.svelte";
  import {togglePasswordVisibility} from "../../reusable/passwordVisibility"

  import '../Home/home.scss'

  import poids from "/src/assets/images/poids.jpg";
  
  export let email, password;

  let userErrorMessage = '';
  let errorMessages = []; 
  let displayError = false;
  let displayDuration = 5000; 
  
  //--------------------------CONNEXION-----------------------------
  async function LoginUser() {
    try {
      const loginResponse = await fetch(`${endpoint}/auth/login`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ email, password })
      });

      const responseData = await loginResponse.json();

      if (loginResponse.ok) {
        const accessToken = responseData.token;
        const number = responseData.number;
        const id = responseData.id;

        localStorage.setItem('accessToken', accessToken);
        localStorage.setItem('id', id);
        localStorage.setItem('isAuthenticated', 'true');
        isAuthenticated.set(true);


        const localStorageData = [
          localStorage.getItem('accessToken'),
          localStorage.getItem('id'),
          localStorage.getItem('isAuthenticated'),
        ];

        console.log(localStorageData);

        isAuthenticated.set(true);
        push("/profil");
        
        window.scrollTo(0, 0);

      } else {

        errorMessages = responseData.errors;

        const errorMessage = errorMessages && (errorMessages.email || errorMessages.password);

        console.log(errorMessages);
        console.log(errorMessage)

        displayError = true;
        setTimeout(() => { 
          displayError = false;
       }, displayDuration);

      }
    } catch (error) {
      console.error('Erreur lors de la connexion :', error.message);
    }
  }
</script>
  
<div class="wrapper-home" >
      
  <div class="fitness-home">  
    <div class="fitness-block">
      <h1>Fitcode Fitness</h1>
      <p><strong>Votre espace sportif privilégié !</strong></p>
    </div>
  </div>
  
  <!-- ------------------------------------login-------------------------------------------- -->
  
  <section class="login-users">
    
    <div class="form-container">
      <h2>Votre espace membre</h2>

      <div class="img-block">
        <img src={poids} class="picture-sport" alt="poids">
      </div>

      <h3>Connectez-vous à votre compte :</h3>

      <form class="form-login" on:submit|preventDefault={LoginUser}>
     
          <div class="form__email">
            <label for="email">Email :</label>
            <input class="email login" id="email" type="email" name="email"  placeholder="ex: tiboinshape@gmail.com" bind:value={email}>
          </div>
    
          <div class="form__password">
            <label for="password">Mot de passe :</label>
            <input class="password login" id="password" type="password" name="password" placeholder="energ!F13tCode" bind:value={password}>
            <i class="fa-solid fa-sm fa-eye"  on:click={togglePasswordVisibility} aria-hidden="true"></i>
          </div>

          <ErrorsMessages 
          error= {userErrorMessage}
          errorMessages= {errorMessages}
          displayError= {displayError}
          />

          <button aria-label="bouton de connexion" class="btn-login" type="submit">Se connecter</button>
          <button class="btn-register"><a use:link href="/inscription" aria-label="Créez-vous un compte" type="submit">Rejoignez-nous</a></button>
      </form>

    </div>
  </section>
  
  <!-- -----------------------------------Team------------------------------------------- -->
    <section class="team-coachs">
      <Coachs />
    </section>

  <!-----------------------------------Comment------------------------------------------------->
    <article class="comments-users">
      <Comments />
    </article>
  </div>