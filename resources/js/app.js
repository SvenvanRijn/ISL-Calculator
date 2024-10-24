function toggleHamburgerMenu(){
    let menu = document.getElementById('mobile-menu');
    if(menu.style.display == "none"){
        menu.toggleAttribute('style');
    }else{
        menu.style.display = 'none';
    }
}

function closeHamburgerMenu(){
    let menu = document.getElementById('mobile-menu');
}