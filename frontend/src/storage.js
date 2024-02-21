import { writable } from "svelte/store";

//Pour gérer les pages qui s'affichent à la connexion
export const isAuthenticated = writable(false);

//Pour l'oeil 
export const togglePasswordVisibility = () => { isVisible = !isVisible };

//Stocke la première partie de l'url des requêtes API
  const endpoint = 'http://127.0.0.1:8000/api';
  export default endpoint;

  

  

