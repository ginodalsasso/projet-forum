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
