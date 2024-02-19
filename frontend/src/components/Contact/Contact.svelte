<script>
  window.scrollTo(0, 0);
  
  import endpoint from '../../storage.js';

  import ErrorsMessages from "../../reusable/ErrorsMessages.svelte";

  import '../Contact/contact.scss'

  import map from "/src/assets/images/map.png";
  
  let lastname, firstname, email, message;

  let userErrorMessage = '';
  let errorMessages = []; 
  let displayError = false;
  let displayDuration = 5000;
  
  async function formContactSubmit() {
      try {
        const response = await fetch(`${endpoint}/contact`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ lastname, firstname, email, message }),
        });

        const responseData = await response.json();
  
        if (response.ok) {

          console.log(responseData);

          const showSuccess = document.querySelector(".success")
          showSuccess.style.display = "block";
          setTimeout(() => {
          showSuccess.style.display = "none";
            }, 2500);

          resetForm();

        } else {

          errorMessages = responseData.errors;

          displayError = true;

          setTimeout(() => { 
              displayError = false;
            }, displayDuration);
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
  
              <form class="form-container" on:submit|preventDefault={formContactSubmit}>
  
                <h2>Nous contacter</h2>

                <div class="form__lastname">
                    <label for="lastname">Nom</label>
                    <input class="lastname contact" id="lastname" type="text" name="lastname" placeholder="Nom"  bind:value={lastname}/>
                </div>
  
                  <div class="form__firstname">
                    <label for="firstname">Prénom :</label>
                    <input class="firstname contact" id="firstname" type="text" name="firstname" placeholder="Prénom"  bind:value={firstname}>
                  </div>
  
                <div class="form__email">
                  <label for="email">Email :</label>
                  <input class="email contact" id="email" type="email" name="email" placeholder="Email"  bind:value={email}>
                </div>
  
                  <div class="form__message">
                    <label for="messsage">Message:</label>
                    <textarea class="message contact" id="message" name="message" placeholder="Message" minlength="15" bind:value={message}></textarea>
                  </div>

                  <ErrorsMessages 
                  error= {userErrorMessage}
                  errorMessages= {errorMessages}
                  displayError= {displayError}
                  />

                  <span class="sucess-message success">Votre message a bien été envoyé</span>
                <button aria-label="bouton de connexion" class="btn-login" type="submit">Valider</button>
  
            </form>
  
  
          <div class="map-block">
              <img src="{map}" class="picture-sport" alt="Carte localisation">
          </div>
  
            </div>
  
      </section>
  