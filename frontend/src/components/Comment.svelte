<script>
    export let title, rating, lastname, age, date, content;
    import endpoint from '../storage.js';

    let comments = [];

    async function getCommentData() {
        try {
          const response = await fetch(`${endpoint}/comments`,);

          if (response.ok) {
            comments = await response.json();
            console.log(response)
            console.log(comments)
          } else {
            console.log("Erreur lors de la récupération des données des commentaires");
          } 
        } catch(error) {
            console.error("Une erreur s'est produite:", error)
        }
    }
    getCommentData() 
</script>

  <h2>Vos avis</h2>

    <i class="fa-solid fa-arrow-left fa-xl"></i>

      <div class="wrapper-comment">

        {#each comments as comment}

          <div class="comment-container">

            <div class="exercice-title">
              <p>{comment.title}</p>
            </div>
    
            <div class="star-comment">

          <div class="rating">
            <input value="5" name="rate" id="star5" type="radio">
            <label title="text" for="star5"></label>
            <input value="4" name="rate" id="star4" type="radio">
            <label title="text" for="star4"></label>
            <input value="3" name="rate" id="star3" type="radio" checked="">
            <label title="text" for="star3"></label>
            <input value="2" name="rate" id="star2" type="radio">
            <label title="text" for="star2"></label>
            <input value="1" name="rate" id="star1" type="radio">
            <label title="text" for="star1"></label>
        </div>
      </div>
    
          <div class="comment-user">
            <p>Par {comment.user.firstname} {comment.user.age} ans, le {comment.date} :</p>
          </div>
    
          <div class="comment-content">
            <p>{comment.content}</p>
          </div>
    </div>

        {/each}

    <i class="fa-solid fa-arrow-right fa-xl"></i>
</div>

