// js/script.js

document.addEventListener('DOMContentLoaded', function() {
    var options = {
        strings: ["Dombry . . ."],
        typeSpeed: 150,
        backSpeed: 50,
        backDelay: 3000,
        loop: true,
        showCursor: false,


    };

    setTimeout(function() {
        var typed = new Typed("#typed-text", options);
    }, 1000);
});