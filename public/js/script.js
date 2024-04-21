var sidenav = document.getElementById("mySidenav");
var openBtn = document.getElementById("openBtn");
var closeBtn = document.getElementById("closeBtn");

openBtn.onclick = openNav;
closeBtn.onclick = closeNav;

//set la largeur de la navigation à 350px;
function openNav(){
    sidenav.classList.add("active");
}

//set la largeur de la navigation à 0;
function closeNav(){
    sidenav.classList.remove('active');
}

const btn = document.querySelector('.toogle_button');
const form = document.querySelector('.toggle_display');

btn.addEventListener('click', () =>{
    form.classList.toggle('is-visible');
});