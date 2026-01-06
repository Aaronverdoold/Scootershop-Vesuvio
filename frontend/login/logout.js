document.getElementById('logout')?.addEventListener('click', async () => {
    try {
        const res = await fetch('../../backend/Domain/login/Logout.php', { method: 'POST', credentials: 'include' });
        if (res.ok)
            location.href = '../login/login.html';
        else
            alert('Logout failed.');
    } catch (err) {
        console.error(err);
        alert('Network error.');
    }
});
