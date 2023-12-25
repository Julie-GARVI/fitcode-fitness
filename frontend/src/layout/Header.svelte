<script>
  import "../style/layout/header.scss";
  import { link } from "svelte-spa-router";
  import logo from "../assets/images/logo.png";
  import { Hamburger } from "svelte-hamburgers";
  import{ isAuthenticated }  from '../storage.js';
  import endpoint from '../storage.js';

  let open = window.innerWidth <= 768 ? false : true;

  // Cette fonction gère le changement de la variable open en fonction de la largeur de la fenêtre.
  function ShowMenu() {
    open = window.innerWidth <= 768 ? false : true;
  }

  const storedIsAuthenticated = localStorage.getItem('isAuthenticated');
if (storedIsAuthenticated === 'true') {
  isAuthenticated.set(true);
}


  window.addEventListener('resize', ShowMenu);

  async function logoutUser() {
    try {
      const logoutResponse = await fetch(`${endpoint}/auth/logout`, {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('accessToken')}`,
          'Content-Type': 'application/json'
        }
      });

      if (logoutResponse.status === 200) {
        isAuthenticated.set(false); // Mettez à jour le store d'authentification
        window.location.href = '/';
        localStorage.clear();
      } else {
        console.log('La déconnexion a échoué.');
      }
    } catch (error) {
      console.error('Erreur lors de la déconnexion :', error.message);
    }
  }
</script>

<header>
  <div class="wrapper-menu">
    {#if !open || window.innerWidth > 768}
    <img src={logo} alt="Logo fitcode fitness" class="logofit" />
    {/if}

    <div class="hamburger-block">
      <Hamburger bind:open />
    </div>

    <nav class="nav-menu" style="{open ? 'display: flex;' : 'display: none;'}">
      {#if open}
      <ul class="main-menu" role="menu">
        <li role="menuitem">
          <a href="/" class="nav-menu__link" aria-label="Liens vers la page d'accueil" use:link>Accueil</a>
        </li>
        <li role="menuitem">
          <a href="/contact" class="nav-menu__link" aria-label="Lien vers la page contact" use:link>Contact</a>
        </li>
        {#if $isAuthenticated}
        <li role="menuitem">
          <a href="/exercices" class="nav-menu__link" aria-label="Liens vers la page nos exercices" use:link>Exercices</a>
        </li>
        <li role="menuitem">
          <a href="/profil" class="nav-menu__link" aria-label="Lien vers la page profil" use:link>Profil</a>
        </li>
        <li role="menuitem">
          <button class="nav-menu__link" aria-label="Se déconnecter" title="Déconnexion" on:click={logoutUser}>
            <i class="fa-solid fa-right-from-bracket fa-xl"></i>
          </button>
        </li>
        {/if}
      </ul>
      {/if}
    </nav>
  </div>
</header>
