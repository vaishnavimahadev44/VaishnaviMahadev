document.addEventListener('DOMContentLoaded', function() {
    
    if (localStorage.getItem('adminLoggedIn') === 'true') {
        window.location.href = 'admin.html';
    }

    const loginForm = document.getElementById('loginForm');
    
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        
        
        if (username === 'admin' && password === 'IcsLegal@tech') {
            localStorage.setItem('adminLoggedIn', 'true');
            localStorage.setItem('adminUsername', username);
            window.location.href = 'adminPanel.html';
        } else {
            const errorMessage = document.querySelector('.ui.error.message');
            errorMessage.textContent = 'Invalid username or password';
            errorMessage.classList.remove('hidden');
        }
    });
});