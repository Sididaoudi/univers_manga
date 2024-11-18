/* Responsive Navbar */

// Select elements
// let menuBurger = document.getElementById("burger");
// let closeMenu = document.getElementById("close");
// let toggleMenu = document.querySelector(".toggle-menu");
// // Assuming .toggle-menu-links is within a container with class "menu-container"
// let toggleMenuLinks = document.querySelector(".menu-container .toggle-menu-links");

// // Track menu state
// let isMenuOpen = false;

// // Function to open menu
// menuBurger.addEventListener("click", function () {
//   console.log("Menu burger clicked");
//   toggleMenu.classList.add("open"); // Show menu
//   closeMenu.style.visibility = "visible"; // Show close icon
//   isMenuOpen = true;
// });

// // Function to close menu
// closeMenu.addEventListener("click", function () {
//   toggleMenu.classList.remove("open"); // Hide menu
//   menuBurger.style.visibility = "visible"; // Show burger icon
//   closeMenu.style.visibility = "hidden"; // Hide close icon
//   isMenuOpen = false;
// });

document.querySelector(".menu-btn").addEventListener("click", function () {
  document.querySelector(".nav-links").classList.toggle("show");
});


/* Research */

// quand je clique sur la loupe cela va ouvrir l'input de rechercher et masquer la loupe

let searchGlass = document.querySelector(".fa-search");
let searchTerm = document.querySelector(".input");

console.log(searchTerm);




