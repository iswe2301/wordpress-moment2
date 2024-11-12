"use strict";

// Vänta på att hela HTML-dokumentet ska laddas klart innan JS-koden körs
document.addEventListener("DOMContentLoaded", function() {

    // Hämta elementen som ska användas
    const menuToggle = document.querySelector(".menu-toggle");
    const mobileMenu = document.querySelector(".mobile-menu");
    const menuIcon = document.querySelector(".fa-bars");
    const closeIcon = document.querySelector(".fa-xmark");
    const overlay = document.getElementById("overlay");

    // Skapa klickhändelselyssnare för menyknappen
    menuToggle.addEventListener("click", () => {
        mobileMenu.classList.toggle("show"); // Växla mellan klassen show för att visa/dölja mobilmenyn
        overlay.classList.toggle("opacity"); // Växla mellan visa/dölja opacity när menyn klickas

        // Kontrollera om mobilmenyn visas eller inte
        if (mobileMenu.classList.contains("show")) {
            // Hamburgerikonen osynlig och kryssikonen synlig
            menuIcon.style.opacity = "0";
            closeIcon.style.opacity = "1";
            closeIcon.style.transform = "translate(-50%, -50%) rotate(360deg)"; // Animera kryssikonen med en rotation på 360 grader
        } else {
            // Hamburgerikonen synlig och kryssikonen osynlig
            menuIcon.style.opacity = "1";
            closeIcon.style.opacity = "0";
            closeIcon.style.transform = "translate(-50%, -50%) rotate(-360deg)"; // Återställ kryssikonens rotation
        }
    });
});