function validateForm() {
    const form = document.querySelector('form');

    document.addEventListener("submit", function(event) {
        const form = event.target;
        
        if (form.tagName.toLowerCase() === 'form') {
            event.preventDefault();

        const lastnameInputs = document.querySelectorAll('.lastname');
        const firstnameInputs = document.querySelectorAll('.firstname');
        const ageInput = document.querySelectorAll('.age');
        const emailInputs = document.querySelectorAll('.email');
        const passwordInput = document.querySelectorAll('.password');
        const messageInputs = document.querySelectorAll('.message');
        const nameInputs = document.querySelectorAll('.name');
        const timeInputs = document.querySelectorAll('.time');
        const instructionsInputs = document.querySelectorAll('.instructions');
        const starInputs = document.querySelectorAll('.star');
        const titleInputs = document.querySelectorAll('.title');
        const contentInputs = document.querySelectorAll('.content');

        let isError = false;
        let tabError = [];


    //Cible tous les champs LASTNAME
        lastnameInputs.forEach(lastname => {
            if (lastname.value === "") {
                isError = true;
                tabError.push("Erreur, le champ nom est vide");
                emptyAlert();
            } else if (specialCharacters(lastname.value)) {
                isError = true;
                lastnamelert() ;
            }
        });

    //Cible tous les champs FIRSTNAME
        firstnameInputs.forEach(firstname => {
            if (firstname.value === "") {
                isError = true;
                tabError.push("Erreur, le champ prénom est vide");
                emptyAlert();
            } else if (specialCharacters(firstname.value)) {
                isError = true;
                firstnameAlert();
            }
        });

    //Cible tous les champs AGE
        ageInput.forEach(age => {
            if (age.value === "") {
                isError = true;
                tabError.push("Erreur, le champ âge est vide");
                emptyAlert();
            } else if (age.value < 12 || age.value > 90) {
                isError = true;
                tabError.push("Erreur, l'âge doit être un nombre entier de 12 à 90");
                limitAgeAlert();
            }
        });
    
    //Cible tous les champs EMAIL
        emailInputs.forEach(email => {
            if (email.value === "") {
                isError = true;
                tabError.push("Erreur, le champ email est vide");
                emptyAlert();
            }
        });

    // Cible tous les champs PASSWORD
        passwordInput.forEach(password => {
            if (password.value === "") {
                isError = true;
                tabError.push("Erreur, le champ mot de passe est vide");
                emptyAlert();
            }
             else if (!/[a-z]/.test(password.value) || !/[A-Z]/.test(password.value) || !/\d/.test(password.value) || !/[!@#$%^&*()_+\-=\[\]{};':"\\|,<>\/?~. ]/.test(password.value) || password.value.length < 8)  {
                isError = true;
                tabError.push("Le mot de passe doit contenir à la fois au moins 8 caractères, une majsucule, une minuscule, un chiffre et un caractère particulier");
                passwordAlert();
            }
            else if (response.status !== 200) {
                isError = true;
                tabError.push("Échec de la connexion. Veuillez vérifier vos informations d'identification.");
                wrongAlert();
            }
          
        });

    //Cible tous les champs MESSAGE
        messageInputs.forEach(message => {
            if (message.value === "") {
                isError = true;
                tabError.push("Erreur, le champ message est vide");
                emptyAlert();
            } else if (specialCharacters(message.value)) {
                isError = true;
                messageAlert();
            } else if (message.value.length < 15) {
                isError = true;
                tabError.push("Le message doit contenir au moins 15 caractères");
                lengthAlert();
            }
            else {
                isError = false;
                tabError.push("Le message est bien envoyée");
                messageSend();
            }
        });

    
    //Cible tous les champs NAME
    nameInputs.forEach(name => {
        if (name.value === "") {
            isError = true;
            tabError.push("Erreur, le champ nom est vide");
            emptyAlert();
        } else if (specialCharacters(name.value)) {
            isError = true;
            nameAlert();
        }
    });

    //Cible tous les champs TIME
    timeInputs.forEach(time => {
        if (time.value === "") {
            isError = true;
            tabError.push("Erreur, le champ temps est vide");
            emptyAlert();
        } 
    });

    //Cible tous les champs INSTRUCTIONS
    instructionsInputs.forEach(instructions => {
        if (instructions.value === "") {
            isError = true;
            tabError.push("Erreur, le champ instruction est vide");
            emptyAlert();
        } else if (specialCharacters(instructions.value)) {
            isError = true;
            instructionsAlert();
        }
    });

    //Cible tous les champs RATING
    starInputs.forEach(star => {
        if (star.value <= 0) {
            isError = true;
            tabError.push("Erreur, le champ rating est vide");
            emptyStarAlert();
        }
    });

    //Cible tous les champs TITLE
    titleInputs.forEach(title => {
        if (title.value === "") {
            isError = true;
            tabError.push("Erreur, le champ titre est vide");
            emptyAlert();
        }
        else if (specialCharacters(title.value)) {
            isError = true;
            titleAlert();
        }
    });

    //Cible tous les champs CONTENT
    contentInputs.forEach(content => {
        if (content.value === "") {
            isError = true;
            tabError.push("Erreur, le champ content est vide");
            emptyAlert();
        }
        else if (specialCharacters(content.value)) {
            isError = true;
            contentAlert();
        }
    });

        function specialCharacters(value) {
            const characters = /[#$%^&*\[\]{}\\|<>\/~]/;
            return characters.test(value);
        }


    //Empêche qu'un formulaire soit vide
        function emptyAlert() {
            const alert = document.querySelector(".empty-alert");
            alert.style.display = "block";

            setTimeout(() => {
                alert.style.display = "none";
            }, 2500);
        }

    //Empêche que le rating soit vide
    function emptyStarAlert() {
        const alert = document.querySelector(".star-alert");
        alert.style.display = "block";

        setTimeout(() => {
            alert.style.display = "none";
        }, 2500);
    }

    //Limite d'âge
        function limitAgeAlert() {
            const alert = document.querySelector(".alert-age");
            alert.style.display = "block";

            setTimeout(() => {
                alert.style.display = "none";
            }, 2500);
        }

    
    //-------------------/PASSWORD-----------------------------
    //Vérifie que tout soit conforme
        function passwordAlert() {
            const alert = document.querySelector(".alert-password");
            alert.style.display = "block";
            console.log(alert)

            setTimeout(() => {
                alert.style.display = "none";
            }, 4000);
        }

        //En cas d'échec de connection
        function wrongAlert() {
            const alert = document.querySelector(".wrong-alert");
            alert.style.display = "block";

            setTimeout(() => {
                alert.style.display = "none";
            }, 4000);
        }

        //-------------------NOM-----------------------------
        function lastnamelert() {
            const alert = document.querySelector(".lastname");
            alert.style.display = "block";

            setTimeout(() => {
                alert.style.display = "none";
            }, 2500);
        }

        //-------------------PRENOM----------------------------
        function firstnameAlert() {
            const alert = document.querySelector(".firstname");
            alert.style.display = "block";

            setTimeout(() => {
                alert.style.display = "none";
            }, 2500);
        }


        //-------------------MESSAGE---------------------------
        function messageAlert() {
            const alert = document.querySelector(".message");
            alert.style.display = "block";

            setTimeout(() => {
                alert.style.display = "none";
            }, 2500);
        }

         //-------------------NAME--------------------------
        function nameAlert() {
            const alert = document.querySelector(".name");
            alert.style.display = "block";

            setTimeout(() => {
                alert.style.display = "none";
            }, 2500);
        }

        //-------------------INSTRUCTIONS-----------------------
        function instructionsAlert() {
            const alert = document.querySelector(".instructions");
            alert.style.display = "block";

            setTimeout(() => {
                alert.style.display = "none";
            }, 2500);
        }

        //-------------------TITLE-----------------------
        function titleAlert() {
            const alert = document.querySelector(".title.alert");
            alert.style.display = "block";

            setTimeout(() => {
                alert.style.display = "none";
            }, 2500);
        }

        //-------------------CONTENT-----------------------
        function contentAlert() {
            const alert = document.querySelector(".content.alert");
            alert.style.display = "block";

            setTimeout(() => {
                alert.style.display = "none";
            }, 2500);
        }

        function lengthAlert() {
            const alert = document.querySelector(".lenght-alert"); 
            alert.style.display = "block";

            setTimeout(() => {
                alert.style.display = "none";
            }, 2500);
        }

    //En cas de succès
        function messageSend() {
            const alert = document.querySelector(".sucess-message"); 
            alert.style.display = "block";

            setTimeout(() => {
                alert.style.display = "none";
            }, 2500);
        }

    }
});
}

validateForm() 