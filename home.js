
let toggler=document.getElementById('toggler');
let navlist=document.getElementById('navlist');

toggler.addEventListener('click', listDisplay)

function listDisplay(){
    //alert()
    navlist.classList.toggle('showList')
}