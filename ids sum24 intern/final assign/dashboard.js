document.addEventListener('DOMContentLoaded', function() {
    // Example functionality: You can add more features as needed

    const logoutButton = document.getElementById('logout-btn');
    if (logoutButton) {
        logoutButton.addEventListener('click', function() {
            // Optionally, add any confirmation or additional functionality before logging out
        });
    }

    const eventsButton = document.getElementById('events-btn');
    if (eventsButton) {
        eventsButton.addEventListener('click', function() {
            // Optionally, add any additional functionality when clicking "Back to Events"
        });
    }
});
