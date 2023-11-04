import Home from "./pages/Home.svelte";
import Inscription from "./pages/Inscription.svelte";
import Contact from "./pages/Contact.svelte";
import Profil from "./pages/Profil.svelte";
import Edit from "./pages/Edit.svelte";
import Exercices from "./pages/Exercices.svelte";
import ExerciceCoach from "./pages/ExerciceCoach.svelte";
import ExerciceMembre from "./pages/ExerciceMembre.svelte";
import NotFound from "./pages/NotFound.svelte";


export default {
  "/": Home,
  "/inscription": Inscription,
  "/contact": Contact,
  "/profil": Profil,
  "/exercices/membre/edit/:id": Edit,
  "/exercices": Exercices,
  "/exercice/coach/:id": ExerciceCoach,
  "/exercice/membre/:id": ExerciceMembre,
    "*": NotFound,
};