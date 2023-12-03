<script>
    import Star from '../components/Star.svelte'
    export let date, user, exerciceId;
    import endpoint from '../storage.js';
        
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

    function isWideScreen() {
        return window.innerWidth;
    }

    window.addEventListener('scroll', () => {
        resize = isWideScreen() <= 1150 ? true : false;
    });
    
    </script>

<div class="section-comments">
    <h2>Votre commentaires :</h2>
    
    {#if comments === false || comments.length === 0}
        <p>Aucun commentaire</p>
    {:else} 
       
            <div class="comment-container">
                {#each comments as comment}
                    <div class="comments-wrapp">
                        <div class="wrapper-stars">
                            {#each [1, 2, 3, 4, 5] as value (value)}
                                <i class="fa-solid fa-star fa-xl" style="{value <= comment.rating ? 'color: yellow;' : 'color: white;'}"></i>
                            {/each}
                        </div>
                        <div class="comments-block">
                            <span class="comment-title">{comment.title}</span>
                            <p>De {comment.user.firstname}, le {comment.date}</p>
                        </div>
                        <div class="comments-content">
                            <p>{comment.content}</p>
                        </div>
                    </div>
                {/each}

                {#if hasMoreComments() && resize}
                    <button class="btn-link" on:click={getCommentExerciceId}>Voir plus</button>
                {/if}

                {#if hasMoreComments() && window.innerWidth > 1150}
                    <h1>Test</h1>
                {/if}
            </div>
        {/if}
</div>
    
    <div class="comment-add">
    
        <h3>Ajoutez votre note</h3>

        <Star bind:rating={rating} /> 

        <form class="form-crud" on:submit|preventDefault={addCommentsExercice}>
            <div class="value title">
                <label for="title">Titre du commentaire :</label>
                <input type="text" id="title" name="title" class="title create" placeholder="Très satisfait de l'entraînement en intervalles" bind:value={title}>
            </div>
                <input type="hidden" id="rating" name="rating" value="0"> 
            <div class="value content">
                <label for="content">Votre commentaire :</label>
                <textarea type="text" id="content" name="content" placeholder="L'entrainement en intervalles m'a permis d'améliorer ma force physique..." bind:value={content}></textarea>
            </div>
            <div class="btn-block">
                <button type="submit" class="btn-submit" aria-label="Ajouter un commentaire">Ajouter</button>
            </div>
        </form>
    
    </div>
    

    