document.addEventListener('DOMContentLoaded', function() {
    // Handle login form submission
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            event.preventDefault();
            // Authenticate the user (for simplicity, assume anyone can log in)
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            // Check if user is admin (this should be done via an API in a real application)
            const isAdmin = email === 'admin@example.com';
            
            // Redirect to main page
            window.location.href = 'main.html';
            
            // Store admin status in sessionStorage
            sessionStorage.setItem('isAdmin', isAdmin);
        });
    }

    // Show admin button if user is admin
    const adminBtn = document.getElementById('admin-btn');
    if (adminBtn) {
        const isAdmin = sessionStorage.getItem('isAdmin') === 'true';
        if (isAdmin) {
            adminBtn.style.display = 'block';
        }
        adminBtn.addEventListener('click', function() {
            window.location.href = 'admin.html';
        });
    }

    // Fetch and display events
    const eventsContainer = document.getElementById('events-container');
    if (eventsContainer) {
        fetch('http://127.0.0.1/ids%20sum24%20intern/assign5/events.php')
            .then(response => response.json())
            .then(data => {
                if (data.records) {
                    data.records.forEach(event => {
                        const eventElement = document.createElement('div');
                        eventElement.textContent = event.name_;
                        eventsContainer.appendChild(eventElement);
                    });
                }
            });
    }

    // Handle event form submission
    const eventForm = document.getElementById('event-form');
    if (eventForm) {
        eventForm.addEventListener('submit', function(event) {
            event.preventDefault();
            // Add event to the database (for simplicity, just log the data)
            const eventName = document.getElementById('event-name').value;
            const eventDateFrom = document.getElementById('event-date-from').value;
            const eventDateTo = document.getElementById('event-date-to').value;
            console.log('Adding event:', { eventName, eventDateFrom, eventDateTo });
        });
    }

    // Handle member form submission
    const memberForm = document.getElementById('member-form');
    if (memberForm) {
        memberForm.addEventListener('submit', function(event) {
            event.preventDefault();
            // Add member to the database (for simplicity, just log the data)
            const memberName = document.getElementById('member-name').value;
            const memberEmail = document.getElementById('member-email').value;
            console.log('Adding member:', { memberName, memberEmail });
        });
    }
    document.getElementById('admin-btn').addEventListener('click', function() {
        window.location.href = 'admin.html';
    });
});
