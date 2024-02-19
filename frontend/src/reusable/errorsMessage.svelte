<script>
    export let errorMessage;
    export let errorMessages; 
    export let displayError;
  
    errorMessage = [
        errorMessages['gender.required'] || 
        errorMessages['lastname.required'] || 
        errorMessages['firstname.required'] || 
        errorMessages['age.required'] || 
        errorMessages['email.required'] || 
        errorMessages['password.required'] ||
        errorMessages['lastname.max'] ||
        errorMessages['firstname.max'] ||
        errorMessages['age.min'] ||
        errorMessages['age.max'] ||
        errorMessages['email.email'] ||
        errorMessages['email.unique'] ||
        errorMessages['regex'] ||
        errorMessages['password.min'] ||
        errorMessages['passwordRegex'] ||
        errorMessages['string']
    ]
</script>

    <div class="alert" style="display: {displayError ? 'block' : 'none'}">
        {#each Object.values(errorMessages) as error}
            <div>{"Erreur ! " + error}</div>
        {/each}
    </div>