/* HERO ROTATING BANNER */
/* This looks through the HTML Document and the finds the element with id="heroTrack", and stores it inside the heroTrack variable */
const heroTrack = document.getElementById("heroTrack");
/* This finds the arrow button element in the HTML and stores it in a variable */
const heroNextBtn = document.getElementById("heroNextBtn");

/* This checks whether both elements actually exist before running the rest of the slider code */
if (heroTrack && heroNextBtn) {
    let currentSlide = 0;
    const totalSlides = 3; /* This stores how many slides there are in total */
    let autoRotate; /* This declares a variable that will later store the interval timer ID */
}