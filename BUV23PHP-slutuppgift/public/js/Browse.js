window.onload = function() {
    VanillaTilt.init(document.querySelectorAll(".card"), {
        max: 20,
        speed: 400,
        glare: true,
        "max-glare": 0.4,
    });
    VanillaTilt.init(document.querySelectorAll("#main .btn"), {
        max: 20,
        speed: 400,
        perspective: 1000,
        scale: 1.2,
    });
    VanillaTilt.init(document.querySelectorAll(".card-title"), {
        max: 15,
        speed: 400,
        perspective: 1000,
        scale: 1.2,
    });
};
