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

    //#region Test de timer en javascript
    const targetDate = new Date('2024-12-19T15:56:00');
    let intervalTimer;

function updateTimer()
{
    const now = new Date().getTime();
    const difference = targetDate - now;
    const tournois = document.querySelector('.tournois');

    if (difference > 0) {
        const days = Math.floor(difference / (1000 * 60 * 60 * 24));
        const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((difference % (1000 * 60)) / 1000);

        document.querySelector('.days').innerText = days;
        document.querySelector('.hours').innerText = ('0' + hours).slice(-2);
        document.querySelector('.minutes').innerText = ('0' + minutes).slice(-2);
        document.querySelector('.seconds').innerText = ('0' + seconds).slice(-2);
    } else {
        clearInterval(intervalTimer);
        if(document.querySelector('.vote')) {
            document.querySelector('.vote').style.display = 'none';
        }
        if(document.querySelector('.timer')){
            document.querySelector('.timer').style.display = 'none';
        }

        if(tournois) {
            tournois.style.display = 'block';
        }
    }
}

intervalTimer = setInterval(updateTimer, 1000);
updateTimer();
//#endregion
});
