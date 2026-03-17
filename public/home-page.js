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

/* This creates a function which performs the actual visual movement of the slider */
    const updateHeroSlide = () => {
        /* This moves the hero track horizontally using CSS transform */
        heroTrack.style.transform = `translateX(-${currentSlide * 100}%)`;
    };

/* This creates a funtion which updates the slide number and then moves the banner */
    const goToNextSlide = () => {
        /* This increases the current slide by 1, if it reaches the end, it loops back to 0 */
        currentSlide = (currentSlide + 1) % totalSlides;
        /* This tells the browser to actually display the new slide */
        updateHeroSlide();
    };

/* This creates a function which handles the automatic slide-changing every few seconds */
    const startAutoRotate = () => {
        /* This starts a repeating timer */
        autoRotate = setInterval(() => {
            goToNextSlide();
        }, 5000); /* This ends the interval function and sets the delay to 5000 milliseconds */
    };

/* This creates a function which keeps the timing feeling natural after user interaction */
    const resetAutoRotate = () => {
        /* This stops the currently running interval timer */
        clearInterval(autoRotate);
        startAutoRotate(); /* This starts a fresh 5 second timer again */
    };

}