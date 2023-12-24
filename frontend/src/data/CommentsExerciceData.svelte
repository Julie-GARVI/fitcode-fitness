<script>
    export let rating, title, user, date, content;
</script>

<div class="wrapper-stars">
    {#each [1, 2, 3, 4, 5] as value (value)}
        <i class="fa-solid fa-star fa-xl" style="{value <= rating ? 'color: yellow;' : 'color: #f0f0f0;'}"></i>
    {/each}
</div>

<div class="comments-block">
    <span class="comment-title">{title}</span>
    <p>De {user.firstname}, le {date}</p>
</div>

<div class="comments-content">
    <p>{content}</p>
</div>