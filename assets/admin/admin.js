import './scss/admin.scss';

/**
 * Add class to body when scrolled
 */
let scrollpos = window.scrollY;

const body = document.querySelector("body");
const scrollChange = 10;

window.addEventListener('scroll', function() {
    scrollpos = window.scrollY;

    scrollpos >= scrollChange
        ? body.classList.add('page-scrolled')
        : body.classList.remove('page-scrolled')
    ;
});

/**
 * Toggle fullscreen
 */
const documentElement = document.documentElement;

function openFullscreen() {
    if (documentElement.requestFullscreen) {
        documentElement.requestFullscreen();
    } else if (documentElement.mozRequestFullScreen) {
        documentElement.mozRequestFullScreen();
    } else if (documentElement.webkitRequestFullscreen) {
        documentElement.webkitRequestFullscreen();
    } else if (documentElement.msRequestFullscreen) {
        documentElement.msRequestFullscreen();
    }
}

function closeFullscreen() {
    if (document.exitFullscreen) {
        document.exitFullscreen();
    } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
    } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
    }
}

document.addEventListener('click', function(e) {
    if (e.target.id !== 'toggleFullscreen') {
        return;
    }

    if (document.fullscreenElement) {
        closeFullscreen();
        e.target.innerHTML = '[ ]';
    } else {
        openFullscreen();
        e.target.innerHTML = '] [';
    }
}, false);
