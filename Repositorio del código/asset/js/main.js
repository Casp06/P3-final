function mostrarContraseña (idPassaword, idIcon){
    let inputPassword = document.getElementById(idPassaword);
    let icon = document.getElementById(idIcon);
    if(inputPassword.type =="password" && icon.classList.contains("fa-eye")) {
        inputPassword.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
    }else{
        inputPassword.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
    }
}