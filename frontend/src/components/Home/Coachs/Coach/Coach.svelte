<script>

    import '../Coach/coach.scss'

    export let lastname, firstname, age, categories, description, multimedia;
    console.log(categories)
</script>
  
<div class="teams-content">
    <div class="teams-img">
        <img src={`http://127.0.0.1:8000/users/${multimedia.picture_path}`} class="coachs-picture" alt={`Photo de ${firstname} ${lastname}`}>
    </div>
  
    <div class="teams-name">
        <p><span>{firstname} {lastname}</span></p>
        <p>{age} ans</p>
    </div>
 
    {#each categories as category}
        <div class="teams-category">
            <img src={`http://127.0.0.1:8000/icons/${multimedia.icon_path}`} class="category-icon" alt={`Icone de ${category.name}`}>
            <p>{category.name}</p>
        </div>
    {/each}
  
    <div class="teams-description">
        <p>{description}</p>
    </div>
</div>