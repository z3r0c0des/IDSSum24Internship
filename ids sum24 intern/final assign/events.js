document.addEventListener('DOMContentLoaded', function() {
    const eventsContainer = document.getElementById('events-container');
    const lookupForm = document.getElementById('lookupForm');

    // Function to fetch events based on the status
    function fetchEvents(status = '') {
        console.log("Fetching events with status:", status); // Debugging line
        fetch(`events.php?status=${status}`)
            .then(response => response.json())
            .then(data => {
                console.log("Fetched data:", data); // Debugging line
                eventsContainer.innerHTML = ''; // Clear the container

                if (data.records && data.records.length > 0) {
                    data.records.forEach(event => {
                        const eventElement = document.createElement('div');
                        eventElement.classList.add('event');
                        eventElement.innerHTML = `
                            <h3>${event.name}</h3>
                            <p>Category: ${event.category}</p>
                            <p>Date: ${event.date_from} to ${event.date_to}</p>
                            <p>Destination: ${event.destination}</p>
                            <p>Description: ${event.description}</p>
                            <p>Cost: ${event.cost}</p>
                            <p>Status: ${event.status}</p>
                        `;
                        eventsContainer.appendChild(eventElement);
                    });
                } else {
                    eventsContainer.innerHTML = '<p>No events found.</p>';
                }
            })
            .catch(error => console.error('Error fetching events:', error));
    }

    // Fetch all events on initial load
    fetchEvents();

    // Handle the lookup form submission
    lookupForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting traditionally
        console.log("Form submission prevented"); // Debugging line
        const status = document.getElementById('status').value;
        console.log("Selected status:", status); // Debugging line
        fetchEvents(status); // Fetch events based on selected status
    });
});
