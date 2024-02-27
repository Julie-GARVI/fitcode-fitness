<script>
    export let errorMessages, displayError;
    
    console.log('errorMessages:', errorMessages);
    console.log('displayError:', displayError);

</script>

    <div class="alert" style="display: {displayError ? 'block' : 'none'}">
        {#each Object.values(errorMessages) as error}
            <div>{"Erreur ! " + error}</div>
        {/each}
    </div>