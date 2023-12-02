<script>

  let stars = "";
  export let rating;

  const starSelect = (event) => {
   
    document.querySelectorAll('.star-mouseover').forEach(star => {
      star.style.color = "";
    });

    stars = event.target;
    console.log(stars)
    stars.style.color = "yellow";

    let previousStar = stars.previousElementSibling;
    previousStar.style.color = "yellow"

    while(previousStar) {
      previousStar.style.color = "yellow";
      previousStar = previousStar.previousElementSibling;
    }
  }

 const resetStars = (event) => {

  if (event === 'click') {
    document.querySelectorAll('.fa-star').forEach(star => {
      star.style.color = "yellow";
    });

    
      document.querySelectorAll('.fa-star').forEach(star => {
      star.style.color = "white";
    });
  }
}

  
  const rateStar = () => {
  // Utilisez dataset.value pour récupérer la valeur du dataset
  rating = parseInt(stars.dataset.value, 6);
  console.log("Rating:", rating);
  // Ajustez la couleur ici pour que toutes les étoiles jusqu'à la cible restent jaunes
  document.querySelectorAll('.fa-star').forEach(star => {
    if (parseInt(star.dataset.value, 6) <= rating) {
      star.style.color = "yellow";
    }
  });
}


</script>
  
  <div class="wrapper-stars" on:mouseout={resetStars} role="button" tabindex="0" on:blur={() => {}}>
      {#each [1, 2, 3, 4, 5] as value (value)}
      <i class="fa-solid fa-star star-mouseover fa-xl" data-value={value} on:mouseover={starSelect} on:click={rateStar} type="button" tabindex="0" on:focus={() => {}}></i>
    {/each}
  </div>

<input type="hidden" id="rating" name="rating" bind:value={rating} on:submit={rateStar}> 
