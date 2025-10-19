function logout() {
    document.cookie = 'token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
    window.location.href = '/login';
}

async function loadDashboardData() {
    try {
        const response = await fetch('/api/dashboard', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        if (response.ok) {
            const data = await response.json();

            if (data.user && data.user.isAdmin && data.dashboard) {
                const totalUsersEl = document.getElementById('totalUsers');
                if (totalUsersEl) {
                    totalUsersEl.textContent = data.dashboard.systemStats.totalUsers || '0';
                }
            }
        } else {
            if (response.status === 401) {
                logout();
            }
        }
    } catch (error) {
        console.error('Failed to load dashboard data:', error);
    }
}

document.addEventListener('DOMContentLoaded', loadDashboardData);