<script>
    import Star from '../components/Star.svelte'
    export let date, user, exerciceId;
    import endpoint from '../storage.js';
  
    let comments = [];
    let title = '';
    let content = '';
    let isCommented = false;
    let rating = 0;
  
    async function getCommentExerciceId() {
      try {
        // ... (votre code existant)
      } catch (error) {
        console.error("Une erreur s'est produite:", error)
      }
    }
    getCommentExerciceId()
  
    async function addCommentsExercice() {
      try {
        // ... (votre code existant)
      } catch (error) {
        console.error("Erreur lors de l'envoi du commentaire :", error);
      }
    }
  </script>
  
  <section class="wrapper-comments">
  
    <h2>Votre avis sur l'exercice</h2>
  
    {#if comments === false || comments.length === 0}
      <p>Aucun commentaire</p>
    {:else}
      <div class="comment-container">
        <div class="comment-item">
          <p>Commentaires :</p>
        </div>
  
        {#each comments as comment}
          <div class="comments-wrapp">
            <div class="comments-block">
              <span class="comment-title">{comment.title}</span>
              <p>De {comment.user.firstname}, le {comment.date}</p>
            </div>
            <div class="wrapper-stars">
              {#each [1, 2, 3, 4, 5] as value (value)}
                <i class="fa-solid fa-star fa-xl" style={{value <= comment.rating ? 'color: yellow;' : 'color: white;'}}></i>
              {/each}
            </div>
            <div class="comments-content">
              <p>{comment.content}</p>
            </div>
          </div>
        {/each}
      </div>
    {/if}
  
    <div class="comment-add">
      <h3>Ajoutez un commentaire</h3>
      <Star bind:rating={rating}/>
      <form class="form-crud" on:submit|preventDefault={addCommentsExercice}>
        <!-- ... (votre code existant) -->
      </form>
    </div>
  
  </section>