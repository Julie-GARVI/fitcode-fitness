import Home from "../src/components/Home/Home.svelte";
import Inscription from "../src/components/Register/Register.svelte";
import Contact from "../src/components/Contact/Contact.svelte";
import Profil from "../src/components/Profile/Profile.svelte";
import Edit from "../src/components/Edit/Edit.svelte";
import Exercices from "../src/components/Exercices/Exercices.svelte";
// import ExerciceCoach from "../src/components/Home/Home.svelte";
import Exercice from "../src/components/Exercice/Exercice.svelte";
import NotFound from "../src/components/NotFound.svelte";


export default {
  "/": Home,
  "/inscription": Inscription,
  "/contact": Contact,
  "/profil": Profil,
  "/exercices/membre/edit/:id": Edit,
  "/exercices": Exercices,
  "/exercice/:id": Exercice,
    "*": NotFound,
};