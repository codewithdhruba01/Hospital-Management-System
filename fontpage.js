    const toggle = document.getElementById('themeToggle');
    const body = document.body;

    // Set theme from localStorage if available
    if (localStorage.getItem('theme') === 'dark') {
        body.classList.add('dark-mode');
        if (toggle) toggle.checked = true;
    }

    // Toggle handler
    if (toggle) {
        toggle.addEventListener('change', () => {
            body.classList.toggle('dark-mode');
            if (body.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.setItem('theme', 'light');
            }
        });
    }


