

export const togglePasswordVisibility = () => {
const passwordFields = document.querySelectorAll(".password");

    passwordFields.forEach((password) => {

            if (password.type === "password") {
                password.type = "text";

            } else {
                password.type = "password";
                console.log(isVisible);
            }
        
        });
};





