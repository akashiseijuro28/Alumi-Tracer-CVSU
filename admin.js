btn.addEventListener('click', slidebar);
btn.addEventListener('click', change_icon);

// Sidebar
function slidebar(){
    let sidebar = document.querySelector('.side-bar');
    let btn = document.querySelector('.toggle');
    sidebar.classList.toggle('side-bar-active');

    let content = document.querySelector('.content-box');
    content.classList.toggle('content-box-active'); 
}
// Icon
function change_icon(){
    let icon = document.getElementById('btn');
    if(icon.classList.contains('fa-bars')){
        icon.classList.replace('fa-bars', 'fa-times');
    }else{
        icon.classList.replace('fa-times', 'fa-bars');
    }
}
function ann_dropdown(){
    
}
// Dropdown (Announcement)
let dropdown = document.querySelector('.select-dropdown');

dropdown.addEventListener('click', function(){
    dropdown.classList.toggle('active');
})

function myFunction(){
    let myIcon = document.getElementById('arrow');
    let list_drpdown = document.querySelector('.list-drpdown');

    if(myIcon.classList.contains('fa-caret-right')){
        myIcon.classList.replace('fa-caret-right', 'fa-caret-down');
    }else{
        myIcon.classList.replace('fa-caret-down', 'fa-caret-right');
    }
    list_drpdown.classList.toggle('active-2');
}
function myFunction_1(){
    let myIcon = document.getElementById('arrow-1');
    let list_drpdown = document.querySelector('.list-drpdown-1');

    if(myIcon.classList.contains('fa-caret-right')){
        myIcon.classList.replace('fa-caret-right', 'fa-caret-down');
    }else{
        myIcon.classList.replace('fa-caret-down', 'fa-caret-right');
    }
    list_drpdown.classList.toggle('active-3');
}




   

    



