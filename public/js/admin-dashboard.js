/* This creates a constant variable called menuBtn, which looks through the HTML Page 
and finds the element that has id="menuBtn" */
const menuBtn = document.getElementById("menuBtn"); 

/* This function is run when the user clicks this button, => means the function will do 
the following */
menuBtn.addEventListener("click", () => {
  /* This means that if the body does not have the class siderbar-collapsed, then add it.
  If the body already has sidebar-collapsed, then remove it */
  document.body.classList.toggle("sidebar-collapsed");
});
