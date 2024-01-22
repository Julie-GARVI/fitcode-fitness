<script>
    import endpoint from '/src/storage.js';

    import Star from '/src/lib/Star.svelte'
    import Comment from './Comment/Comment.svelte';

    import '../Comments/comments.scss'

    export let date, user, exerciceId;
        
    let comments = [];
    let title = '';
    let content = '';
    let isCommented = false;
    let rating = 0;
    let page = 1; 
    const commentsPerPage = 4;
    let resize = window.innerWidth <= 1150 ? true : false;
    
    async function getCommentExerciceId() {
            try {
                const response = await fetch(`${endpoint}/exercice/${exerciceId}/comments?page=${page}&perPage=${commentsPerPage}`,{
                    method: 'GET',
                    headers: {
                        'Authorization' : `Bearer ${localStorage.getItem('accessToken')}`,  
                        'Content-Type': 'application/json'
                    },
                });
    
              if (response.ok) {
        
                const newComments = await response.json();

                comments = [...comments, ...newComments];

                console.log(response)
                console.log(comments)
                console.log(isCommented)
                
                page += 1;


              } else {
                console.log("Erreur lors de la récupération des données des commentaires");
           
              } 
            } catch(error) {
                console.error("Une erreur s'est produite:", error)
            }
    }

    
    getCommentExerciceId();
   

    async function addCommentsExercice() {

    try {
        const commentResponse = await fetch(`${endpoint}/exercice/${exerciceId}/comments`, {
            method: 'POST',
            headers: {
                'Authorization' : `Bearer ${localStorage.getItem('accessToken')}`,  
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({title, date, rating, content, user})
            
        });


        if (commentResponse.ok)  {
            
        const responseData = await commentResponse.json();
        console.log(commentResponse);
        console.log(responseData);

        const form = document.querySelector(".form-crud");
        form.reset();

        const addCommentsInDom = document.querySelector(".comment-container")
                console.log(addCommentsInDom)


                        //------------------------Ajout de la 1ère div--------------------------------
                        const addCommentsWrapp = document.createElement("div");
                        addCommentsWrapp.classList.add("comments-wrapp");
                        addCommentsInDom.prepend(addCommentsWrapp);


                                //--------------Ajout des étoiles-----------------------                                
                                const addWrapperStars = document.createElement("div")
                                addWrapperStars.classList.add('wrapper-stars')
                                addCommentsWrapp.append(addWrapperStars);

                                    for (let i = 1; i <= 5; i++) {
                                      const addStars = document.createElement("i");
                                      addStars.className = "fa-solid fa-star fa-xl";

                                       
                                      addStars.style.color = i <= rating ? 'yellow' : '#f0f0f0';

                                      addWrapperStars.appendChild(addStars);
                                    }


                                    //------------------------Ajout de la 2ème div--------------------------------
                                    const addCommentsBlock = document.createElement("div");
                                    addCommentsBlock.classList.add("comments-block");
                                    addCommentsWrapp.append(addCommentsBlock);


                                            //--------------Ajout du titre du commentaire-----------------------
                                            const addTitleComment = document.createElement("span");
                                            addTitleComment.textContent = responseData.title;
                                            addTitleComment.classList.add("comment-title");
                                            addCommentsBlock.append(addTitleComment);


                                            //--------------Ajout du prénom et de la date-----------------------
                                            const addNameComment = document.createElement("p");
                                            addNameComment.textContent = `de ${responseData.user.firstname}, le ${responseData.date}`;
                                            addCommentsBlock.append(addNameComment);


                                    //------------------------Ajout de la 3ème div--------------------------------
                                    const addCommentsBlockContent = document.createElement("div");
                                    addCommentsBlockContent.classList.add("comments-content");
                                    addCommentsWrapp.append(addCommentsBlockContent);

                                            const addCommentsContent = document.createElement("p");
                                            addCommentsContent.textContent = responseData.content;
                                            addCommentsBlockContent.append(addCommentsContent);

                    getCommentExerciceId();
  
        } else {

            console.log("Échec de la requête.", commentResponse.status);
      
        }
    } catch (error) {

        console.error("Erreur lors de lors de l'envoi du commentaire :", error);
    }
}

    function hasMoreComments() {
        return comments.length % commentsPerPage === 0;
    }


    function isSmallScreen() {
        return window.innerWidth;
    }

    window.addEventListener('scroll', () => {
        resize = isSmallScreen() <= 1150 ? true : false;
    });


     //-----------------Supprimer un commentaire------------------------ 
     async function deleteComment(id) {
  
  try {
      const dataresponse = await fetch(`${endpoint}/exercice/${id}/comment`, {
      method: 'DELETE',
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('accessToken')}`,
        'Content-Type': 'application/json'
      },
    });
    const comment = await dataresponse.json();
    console.log(comment)

    const commentDelete = document.querySelector('.comments-wrapp');
    console.log(commentDelete)
    commentDelete.remove();

    } catch (error) {
    console.error('Une erreur s\'est produite:', error);
  }
}
    

    
    </script>

<div class="section-comments">
    <h2>Votre commentaires :</h2>
    
    {#if comments === false || comments.length === 0}
        <p>Aucun commentaire</p>
    {:else} 
       
   
    <div class="comment-container" on:scroll={getCommentExerciceId}>
      {#each comments as comment}
          <div class="comments-wrapp">
            
            <Comments
            title={comment.title}
            rating={comment.rating}
            user={comment.user}
            date={comment.date}
            content={comment.content}
                 />

              {#if comment.user.id == localStorage.getItem('id')}
              <!-- Show delete button only if the comment belongs to the logged-in user -->
              <button class="delete-btn" on:click={() => deleteComment(comment.id)}>Supprimer</button>
            {/if}
          </div>
      {/each}   

      {#if hasMoreComments()}
      <button type="hidden" class="btn-link" on:click={getCommentExerciceId}>Voir plus</button>
  {/if}
  
  </div>
{/if}  
</div>     
            
    
    <div class="comment-add">
    
        <h3>Ajoutez votre note</h3>

        <Star bind:rating={rating} /> 

        <form class="form-crud" on:submit|preventDefault={addCommentsExercice}>
    
            <div class="value title">
            <span class="empty-alert alert">Erreur, un champs est vide</span>

            <span class="title alert">Erreur ! Votre titre ne doit pas contenir de caractères particuliers</span>
                <label for="title">Titre du commentaire :</label>
                <input type="text" id="title" class="title create" name="title" placeholder="Très satisfait de l'entraînement en intervalles" bind:value={title}>
            </div>
                <input type="hidden" id="rating" name="rating" value="0"> 
            <div class="value content">

            <span class="content alert">Erreur ! Votre commentaire ne doit pas contenir de caractères particuliers</span>
                <label for="content">Vos commentaires :</label>
                <textarea type="text" id="content" class="content create" name="content" placeholder="L'entrainement en intervalles m'a permis d'améliorer ma force physique..." bind:value={content}></textarea>
            </div>
            <div class="btn-block">
                <button type="submit" class="btn-submit" aria-label="Ajouter un commentaire">Ajouter</button>
            </div>
        </form>
    
    </div>
    

    