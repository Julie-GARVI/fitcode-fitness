<script>
  
    import endpoint from '/src/storage.js';

    import { Splide, SplideSlide } from '@splidejs/svelte-splide';
    import '@splidejs/svelte-splide/css';

    import Comment from './Comment/Comment.svelte';

    import '../Comments/comments.scss'

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

      <div class="wrapper-comment">

        <Splide aria-label="slider comment" options={ {
          rewind: true,
          gap   : '2rem',
          type: 'slide',
          wheel : true,
          pauseOnHover: true,
          interval: 3500,
          trimSpace: false,
          label: 'Slider avis',
          breakpoints: {
		      1040: {
			    perPage: 2,
		        },
          768: {
			    perPage: 1,
		        },
          },
          perPage: 3,
        }
      }  > 

          {#each comments as comment}

            <SplideSlide class="comment-container">
  
              <Comment
              title={comment.title}
              firstname={comment.user.firstname}
              age={comment.user.age}
              date={comment.date}
              content={comment.content}
              />

          </SplideSlide>

          {/each}

        </Splide>

</div>

