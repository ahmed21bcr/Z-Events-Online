// script.js
document.getElementById('open-menu').addEventListener('click', function() {
    document.getElementById('side-menu').classList.add('open');
});

document.getElementById('close-menu').addEventListener('click', function() {
    document.getElementById('side-menu').classList.remove('open');
});
