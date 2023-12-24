<script>
    window.scrollTo(0, 0);

    import { getIconsData } from "../reusable/getIconData.js"
    import { onMount } from 'svelte';
    import exercices from "../assets/images/exercices.webp";
    import Exercice from "../components/Exercice.svelte";

    let icons = [];

    onMount(async () => {
        try {
        icons = await getIconsData();
        console.log(icons);
        } catch (error) {
        console.error("An error occurred:", error);
        }
    });
    
</script>
    
    <div class="wrapper-exercices">
    
        <div class="background-exercice">
            <img src="{exercices}" alt="Photo d'une adhérente">
        </div>
    
        <section class="fitness-exercices">
    
                <div class="exercice-select">
                    <h2>Choisissez votre exercice</h2>
    
                    <div class="block-items">
                        <div class="items">
                            <i class="fa-regular fa-heart"></i>
                            <h3>Par catégorie</h3>
                        </div>
                    </div>
    
                    <div class="select-block">
                    {#each icons as icon}
                        <div class="category-item">
                            <img src={'http://127.0.0.1:8000/icons/' + icon.icon_path} class="category-picture" alt={'Icone de ' + icon.category[0].name}>
                            <p>{icon.category[0].name}</p>
                        </div>
                    {/each}
                    </div>
    
                    <div class="block-items">
                        <div class="items">
                            <i class="fa-solid fa-medal"></i>
                            <h3>Par niveau</h3>
                        </div>
                    </div>
    
                    <div class="select-option" aria-label="selectionner son niveau">
                        <div class="select debutant" aria-label="niveau débutant">
                            <p>Débutant</p>
                        </div>
                        <div class="select intermédiaire" aria-label="niveau intermédiaire">
                            <p>Intermédiaire</p>
                        </div>
                        <div class="select avancé" aria-label="niveau avancé">
                            <p>Avancé</p>
                        </div>
                    </div> 
                </div>   
        </section>
    
        <section class="exercices-list">
    
        <Exercice 
        name = "name"
        serie = "serie"
        category = "category"
        multimedia = "multimedia"
        time = "time"
        instructions = "instructions"
        />
            
        </section>
    </div>
