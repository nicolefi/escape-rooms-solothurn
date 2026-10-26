
//Menü:Dropdown Escape Rooms
document.getElementById('EscapeRooms').addEventListener('click', function(){
    let dropdown = document.getElementById('dropdown-rooms');
    dropdown.classList.toggle('open');
    this.classList.toggle('open');
})

//Menü:Dropdown Über 
document.getElementById('ueber').addEventListener('click', function(){
    let dropdown = document.getElementById('dropdown-ueber');
    dropdown.classList.toggle('open');
    this.classList.toggle('open');
})

//Bildschirm < 1100px:Durch Burgerbar wird Navigation wieder sichtbar
document.getElementById('burgerbar').addEventListener('click', function(){
    let navigation = document.getElementById('navUl');
    navigation.style.visibility = 'visible';
    document.getElementById('kreuz').classList.toggle('hide');
})

//Burgerbar Klick
document.getElementById('kreuz').addEventListener('click', function(event){
   
    let navigation = document.getElementById('navUl');
    navigation.style.visibility = 'hidden';
    document.getElementById('kreuz').classList.toggle('hide');
})