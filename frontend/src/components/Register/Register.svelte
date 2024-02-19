<script>
    window.scrollTo(0, 0);

    import { isAuthenticated } from "/src/storage.js";
    import endpoint from "/src/storage.js";
    import { push } from "svelte-spa-router";

    import ErrorsMessages from "../../reusable/ErrorsMessages.svelte";

    import '../Register/register.scss'

    import poidsremove from "/src/assets/images/poidsremove.png";

    export let gender, lastname, firstname, age, level, email, password, category_id;

    let errorMessages = []; 
    let displayError = false;
    let displayDuration = 5000; 

    const categoriesData = [
            { id: 1, name: "Musculation" },
            { id: 2, name: "Yoga" },
            { id: 3, name: "Aquagym" },
            { id: 4, name: "Cardio" }
        ];

    const genderOptions = ['Femme', 'Homme'];

//-----------------------------Création d'un utilisateur-------------------------
async function GetUser() {
    try {
        const registerResponse = await fetch(`${endpoint}/auth/register`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ gender, lastname, firstname, age, level, email, password, category_id})
        });

        const responseData = await registerResponse.json(); 

        if (!registerResponse.ok) {
            
            errorMessages = responseData.errors;

            displayError = true;
            setTimeout(() => { 
                displayError = false;
            }, displayDuration);

        } else {
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

            push("/profil");
        }

    } catch (error) {
        // Gérez l'erreur
        console.error("Erreur lors de l'inscription :", error);
    }
}
</script>

    <section class="register-users">
    
        <div class="register-description">
        <h2>Découvrez notre communauté sportive</h2>
            <ul>
                <li>Accéder à votre espace sportif privé en ligne</li>
                <li>Défiez-vous sur les exercices de coachs qualifiés</li>
                <li>Créez vos exercices sur mesure et suivez les en temps réel</li>
            </ul>
            <img src="{poidsremove}" class="picture-sport" alt="poids">      
        </div>   

            <form class="form-container" on:submit|preventDefault={GetUser}>
    
                <h3>Formulaire d'inscription</h3>

                    <div class="form gender">
                        {#each genderOptions as option (option)}
                            <div class="wo-man">
                                <label for="gender">{option}</label>
                                <input class="{option}" id="gender" type="radio" name="gender" value="{option}" bind:group={gender}>
                            </div> 
                        {/each}
                    </div>
    
                    <div class="form lastname">
                            <label for="lastname">Nom : </label>
                            <input class="lastname register" id="lastname" type="text" name="lastname" max="25" placeholder="Nom"  bind:value={lastname}>
                    </div>
                        
                    <div class="form firstname">
                            <label for="firstname">Prénom :</label>
                            <input class="firstname register" id="firstname" type="text" name="firstname" max="25" placeholder="Prénom" bind:value={firstname}>
                    </div>
                            
                    <div class="form age">
                            <label for="age">Age :</label>
                            <input class="age register" id="age" type="number" name="age" placeholder="Age"  bind:value={age}>
                    </div>
                                            
                    <div class="form email">
                            <label for="email">Email :</label>
                            <input class="form email" id="email"  type="email" name="email" placeholder="Email" bind:value={email}>
                    </div>
    
                    <div class="form password">
                            <label for="password">Mot de passe :</label>
                            <input class="password register" id="password" type="password" name="password" placeholder="Mot de passe" bind:value={password}>
                    <div>

                    <div class="form categories">
                            <span class="select-categories">Choisissez vos préférences :</span>
                                {#each categoriesData as category (category.id)}
                                    <div class={`select-${category.name.toLowerCase()}`}>
                                        <label for={category.id}>
                                            <input type="checkbox" name="category_id" bind:group={category_id} value={category.id}>
                                            {category.name}
                                        </label>
                                    </div>
                                {/each}
                    </div>
                                
                        <select name="level" aria-label="Sélectionner votre niveau" bind:value={level}>
                                <option value="" disabled selected>Votre niveau</option>
                                <option aria-label="niveau débutant" value="débutant">Débutant</option>
                                <option aria-label="niveau intermédiaire" value="intermédiaire">Intermédiaire</option>
                                <option aria-label="niveau avancé" value="avancé">Avancé</option>
                        </select>         

                        <ErrorsMessages 
                        errorMessages= {errorMessages}
                        displayError= {displayError}
                        />

                        <button aria-label="bouton de connexion" class="btn-login" type="submit">S'inscrire</button>
            </form>
    </section>