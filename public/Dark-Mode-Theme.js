/* This reads the previously saved theme from the Browser, using 
localStorage will allow whichever Theme is in use to save even after the Page refreshes */
let darkmode = localStorage.getItem("tecciTheme");
/* This selects the Icon Button, and stores it in JavaScript, so it can then
change the Icon when it is clicked and update the aria-label */
const themeSwitch = document.getElementById("themeToggle");

/* ENABLING DARK MODE */
const enableDarkmode = () => { /* This defines a function, but is not run yet */
    document.body.classList.add("dark-mode"); /* This adds .dark-mode to body to allow CSS to react to the class body.dark-mode {} */
    localStorage.setItem("tecciTheme", "dark"); /* This saves the preference of the Page being in Dark Mode */
    
    /* SWAPS THE DARK MODE ICON (MOON) TO LIGHT MODE ICON (SUN) */
    themeSwitch.innerHTML = '<i class="fa-solid fa-sun"></i>';
    /* This updates the aria label (accessibility text) */
    themeSwitch.setAttribute("aria-label", "Switch to light mode");
};

/* DISABLING DARK MODE */
const disableDarkmode = () => { /* This defines a function, but is not run yet */
    document.body.classList.remove("dark-mode"); /* This removes the class, so the Website returns to its original Tecci colours */
    localStorage.setItem("tecciTheme", "light"); /* This saves the new preference of the Page being in Light Mode */
    
    themeSwitch.innerHTML = '<i class="fa-solid fa-moon"></i>'; /* This restores the Dark Mode (Moon) Icon, so Users know they can switch again */
    /* This updates the aria label again (accessibility text) */
    themeSwitch.setAttribute("aria-label", "Switch to dark mode");
};

/* This runs before any clicks, so if the User previously enabled Dark Mode, the Page loads
correctly immediately */
if (darkmode === "dark") enableDarkmode();

/* CLICK HANDLING */
themeSwitch.addEventListener("click", () => { /* This listens for User interaction, so only triggers when Button is clicked */
    darkmode = localStorage.getItem("tecciTheme"); /* This re-checks the current state */
    if (darkmode !== "dark") {
        enableDarkmode(); /* If not dark, turn Dark Mode on */
    } else {
        disableDarkmode(); /* Else turn Dark Mode off */
    }
});
