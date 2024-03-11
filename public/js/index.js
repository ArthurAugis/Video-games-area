window.addEventListener('DOMContentLoaded', () => {
    // ajoute un événement click à l'élément show-navbar
    document.querySelector('.show-navbar').addEventListener('click', () => {
        const navbar = document.querySelector('.navbar');
        const shownav = document.querySelector('.show-navbar');
        // si la navbar contient déjà la classe active le menu est caché
        if (navbar.classList.contains('active')) {
            navbar.style.marginTop = "-100vh";
            shownav.innerText = "☰";
            // sinon le menu responsive s'ouvre
        } else {
            navbar.style.marginTop = "-7px";
            shownav.innerText = "🗙";
        }
        navbar.classList.toggle('active');
    });

    // ajoute un événement click à l'élément viewpassword
    if(document.querySelector('.viewpassword')) {
        document.querySelector('.viewpassword').addEventListener('click', () => {

            const passwordInputs = document.querySelectorAll('.mdp');

            passwordInputs.forEach(input => {
                if (input.type === "password") {
                    input.type = "text";
                    document.querySelector('.viewpassword').innerHTML = '<i class="fa-solid fa-eye"></i>';
                } else {
                    input.type = "password";
                    document.querySelector('.viewpassword').innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
                }
            });
        });

    }
});
