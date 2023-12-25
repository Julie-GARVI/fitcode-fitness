<script>
  window.scrollTo(0, 0);
  
  import map from "../assets/images/map.png";
  import endpoint from '../storage.js';
  
  let lastname, firstname, email, message;
  
  async function formSubmit() {
      try {
        const response = await fetch(`${endpoint}/contact`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ lastname, firstname, email, message }),
        });
  
        if (response.ok) {
          const responseData = await response.json();
          console.log(responseData);

          const showSuccess = document.querySelector(".success")
          showSuccess.style.display = "block";
          setTimeout(() => {
          showSuccess.style.display = "none";
            }, 2500);

          resetForm();

        } else {
          console.log("Échec de la connexion.");
        }
      } catch (error) {
        console.log("Une erreur s'est produite : " + error.message);
      }
     
    }
    function resetForm() {
      const resetForm = document.querySelector("form");
      resetForm.reset();
    }

  
  
  </script>
  
      <section class="contact-form">
  
            <div class="wrapper-contact">
  
              <form class="form-container" on:submit|preventDefault={formSubmit}>
  
                <h2>Nous contacter</h2>
  
                <span class="empty-alert alert">Erreur, un champs est vide</span>
  
                <span class="lastname alert">Erreur ! Votre nom ne doit pas contenir de caractères particuliers</span>
                <div class="form__lastname">
                    <label for="lastname">Nom</label>
                    <input class="lastname contact" id="lastname" type="text" name="lastname" placeholder="Nom"  bind:value={lastname}/>
                </div>
  
                <span class="firstname alert">Erreur ! Votre prénom ne doit pas contenir de caractères particuliers</span>
                  <div class="form__firstname">
                    <label for="firstname">Prénom :</label>
                    <input class="firstname contact" id="firstname" type="text" name="firstname" placeholder="Prénom"  bind:value={firstname}>
                  </div>
  
                <div class="form__email">
                  <label for="email">Email :</label>
                  <input class="email contact" id="email" type="email" name="email" placeholder="Email"  bind:value={email}>
                </div>
  
                <span class="message alert">Erreur ! Votre message ne doit pas contenir de caractères particuliers</span>
                <span class="lenght-message alert">Erreur ! Votre message doit faire au moins 15 caractères</span>
                  <div class="form__message">
                    <label for="messsage">Message:</label>
                    <textarea class="message contact" id="message" name="message" placeholder="Message" minlength="15" bind:value={message}></textarea>
                  </div>
                  <span class="sucess-message success">Votre message a bien été envoyé</span>
                <button aria-label="bouton de connexion" class="btn-login" type="submit">Valider</button>
  
            </form>
  
  
          <div class="map-block">
              <img src="{map}" class="picture-sport" alt="Carte localisation">
          </div>
  
            </div>
  
      </section>
  