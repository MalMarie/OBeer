const loader = document.querySelector('.loader');

/*quand le site aura chargé*/
window.addEventListener('load', () => {

    loader.classList.add('fondu-out');

    loader.remove();
})