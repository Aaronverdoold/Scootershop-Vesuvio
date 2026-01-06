document.addEventListener('DOMContentLoaded', async () => {
    const el = document.getElementById('username');
    if (!el) return;

    try {
        const res = await fetch('../../backend/Domain/login/GetUser.php', {
            method: 'GET',
            credentials: 'include'
        });

        if (!res.ok) {
            el.textContent = '';
            return;
        }

        const data = await res.json();
        if (data.ok && data.username) {
            el.textContent = data.username;
        } else {
            el.textContent = '';
        }
    } catch (err) {
        console.error('Error fetching username:', err);
        el.textContent = '';
    }
});
