<script>
    let stars = "";
    let rating = "";
  
    const starSelect = (event) => {
     
      document.querySelectorAll('.fa-star').forEach(star => {
        star.style.color = "";
      });
 
      stars = event.target;
      stars.style.color = "yellow";

      let previousStar = stars.previousElementSibling;
      previousStar.style.color = "yellow"

      while(previousStar) {
        previousStar.style.color = "yellow";
        previousStar = previousStar.previousElementSibling;
      }
    }

   const resetStars = () => {
      
        document.querySelectorAll('.fa-star').forEach(star => {
        star.style.color = "white";
      });
    }

  </script>
    
  <div class="wrapper-stars" on:mouseout={resetStars} role="button" tabindex="0" on:blur={() => {}}>
    {#each [1, 2, 3, 4, 5] as value (value)}
      <i class="fa-solid fa-star fa-xl" data-value={value} on:mouseover={starSelect} role="button" tabindex="0" on:focus={() => {}}></i>
    {/each}
  </div>


  <style>
    .wrapper-stars {
        display: block;
        margin-inline: auto;
        width: 150px;
    }
  
    i {
        color: white;
        cursor: pointer;
    }
  </style>
  

   