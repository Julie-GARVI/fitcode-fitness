<script>
    export let userErrorMessage, exerciceErrorMessage, errorMessages, displayError;
  
    userErrorMessage = [
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
        errorMessages && (errorMessages.email || errorMessages.password)
    ]

    exerciceErrorMessage = [
        errorMessages['name.required'] || 
        errorMessages['time.required'] || 
        errorMessages['instruction.required'] || 
        errorMessages['category_id.required'] 
    ]

</script>

    <div class="alert" style="display: {displayError ? 'block' : 'none'}">
        {#each Object.values(errorMessages) as error}
            <div>{"Erreur ! " + error}</div>
        {/each}
    </div>