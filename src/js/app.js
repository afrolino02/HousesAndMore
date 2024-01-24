document.addEventListener('DOMContentLoaded', function() {
    console.log('nada')
    listeners();

    darkMode();
});
function darkMode(){
    const prefiereDarkMode = window.matchMedia('prefers-color-scheme:dark');
    
    
    const botondarkMode = document.querySelector('.dark-mode-boton')

    if(prefiereDarkMode.matches) {
        document.body.classList.add('dark-mode');
    }else {
        document.body.classList.remove('dark-mode');
    }
    botondarkMode.addEventListener('click', function( ){
        document.body.classList.toggle('dark-mode');
    })

}
function listeners(){
    const mobileMenu = document.querySelector('.mobile-menu');
    
    mobileMenu.addEventListener('click', navegacionResponsive)
   
}


function navegacionResponsive( ){
    const navegacion = document.querySelector('navegacion');

    if(navegacion.classList.contains('mostrar')){
        navegacion.classList.remove('mostrar')
    }
    else {
        navegacion.classList.add('mostrar')
    }
}