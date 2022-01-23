const navopen = document.querySelector('.fa-bars'); 
const navclose = document.querySelector('.closebtn');

navopen.addEventListener("click", function() {
    document.querySelector('.Sidenav').style.width = "250px";
        
});

navclose.addEventListener("click", function() {
    document.querySelector('.Sidenav').style.width = "0px";

});

