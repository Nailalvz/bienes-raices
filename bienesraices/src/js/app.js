document.addEventListener('DOMContentLoaded', function() {
    eventListeners();

    darkmode();
});

function eventListeners(){
   const mobileMenu = document.querySelector('.movil-menu');

   mobileMenu.addEventListener('click', navegacionResponsive);
}

function darkmode(){

    // Para saber si el usuario prefiere modo-oscuro
    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark');

    if(prefiereDarkMode.matches){
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }

    // Para escuchar si el usuario cambia de tema a claro u oscuro
    prefiereDarkMode.addEventListener('change', function() {
        if(prefiereDarkMode.matches){
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    });

    const botonDarkMode = document.querySelector('.dark-mode-boton');

    botonDarkMode.addEventListener('click', function() {
        document.body.classList.toggle('dark-mode')
    });

}

function navegacionResponsive(){
    const navegacion = document.querySelector('.navegacion');
    const darkMode = document.querySelector('.dark-mode-contenedor');

    if(navegacion.classList.contains('mostrar')){
        navegacion.classList.remove('mostrar');
    } else {
        navegacion.classList.add('mostrar');
    }
    darkMode.classList.toggle('mostrar');

    // El toggle agrega la clase si no la tiene y si la tiene la borra. Es lo mismo que el código de arriba
    // navegacion.classList.toggle('mostrar');
}