
export const togglePasswordVisibility = () => {
    const passwordField = document.querySelector(".password");
    const eyeIcon = document.querySelector("#eye-icon");

    console.log("test")

    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.className = "fa fa-eye-slash";
    } else {
        passwordField.type = "password";
        eyeIcon.className = "fa fa-eye";
    }
};