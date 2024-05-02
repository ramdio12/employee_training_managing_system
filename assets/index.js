const navlinks = document.querySelectorAll("ul li a");
const openBar = document.querySelector("#open");
const closeBar = document.querySelector("#close");
const navList = document.querySelector(".nav-list");



openBar.addEventListener('click', () => {
    closeBar.style.display = "block";
    openBar.style.display = "none";
    navList.classList.add("active")
})

closeBar.addEventListener('click', () => {
    openBar.style.display = "block";
    closeBar.style.display = "none";
    navList.classList.remove("active")
})


navlinks.forEach(navlink => {
    navlink.addEventListener('click', () => {
        document.title = navlink.textContent;
    })
})


// participantform.addEventListener('submit', (e) => {
//     e.preventDefault();
// })


// const navlinks = document.querySelectorAll("nav a");


// navlinks.forEach(navlink => navlink.classList.add("navlinks"));
