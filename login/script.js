function saveUserInfoToCache(user) {
    localStorage.setItem('user_role', user.role);
    localStorage.setItem('user_name', user.username);
}

function getUserInfoFromCache() {
    return {
        role: localStorage.getItem('user_role'),
        username: localStorage.getItem('user_name')
    };
}

document.getElementById('open-menu').addEventListener('click', function() {
    document.getElementById('side-menu').classList.add('open');
});

document.getElementById('close-menu').addEventListener('click', function() {
    document.getElementById('side-menu').classList.remove('open');
});
