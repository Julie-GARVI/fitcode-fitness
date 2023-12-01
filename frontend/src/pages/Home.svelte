<script>
    window.scrollTo(0, 0);
    
  import poids from "../assets/images/poids.jpg";
  import Team from "../components/Team.svelte";
  import CommentsHome from "../components/CommentsHome.svelte";
  import endpoint from '../storage.js';
  import { link, push } from "svelte-spa-router";
  import { isAuthenticated } from "/src/storage.js";
  
  export let email, password;
  

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

  if (loginResponse.ok) {
    const responseData = await loginResponse.json();
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

    console.error('Erreur lors de la connexion :', loginResponse.status);
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
                      <!-- svelte-ignore a11y-img-redundant-alt -->
                      <img src="{poids}" class="picture-sport" alt="Image de poids">
                  </div>
  
                      <h3>Connectez-vous à votre compte :</h3>
  
                  <form class="form-login" on:submit|preventDefault={LoginUser}>
  
                      <span class="empty-alert alert">Erreur, un champs est vide</span>
                      <span class="wrong-alert alert">L'identifiant ou le mot de passe est incorrect</span>
  
                      <div class="form__email">
                          <label for="email">Email :</label>
                          <input class="email login" id="email" type="email" name="email"  placeholder="ex: tiboinshape@gmail.com" bind:value={email}>
                      </div>
  
                      <span class="alert-password alert">Le mot de passe est incorrect</span>
  
                      <div class="form__password">
                          <label for="password">Mot de passe :</label>
                          <input class="password login" id="password" type="password" name="password" placeholder="energ!F13tCode" bind:value={password}>
                      </div>
  
                      <button aria-label="bouton de connexion" class="btn-login" type="submit">Se connecter</button>

                      <button class="btn-register"><a use:link href="/inscription" aria-label="Créez-vous un compte" type="submit">Rejoignez-nous</a></button>
  
                  </form>
          </div>
  
      </section>
  
  <!-- -----------------------------------Team------------------------------------------- -->
  
      <section class="team-coachs">
  
          <Team
          multimedia = "multimedia"
          lastname = "lastname"
          firstname = "firstname"
          age = "age"
          category = "category"
          description = "description" />
  
      </section>

    <article class="comments-users">
        <CommentsHome
        title = "title"
        rating = "rating"
        lastname = "lastname"
        age = "age"
        date = "date"
        content = "content"/>
    </article>

  </div>
  
  
