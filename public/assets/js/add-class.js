document.addEventListener('DOMContentLoaded', function() {

    const form = document.getElementById('class-form');

    const submitButton = document.getElementById('submit-button');

    form.addEventListener('submit', function(event) {

        event.preventDefault(); // Prevent default form submission

        // Validate start and end times
        const startTime = document.getElementById('start-time').value;
        const endTime = document.getElementById('end-time').value;

        if (startTime >= endTime) {
            // Show error message
            alert('Start time must be less than end time');
            return;
        }

        // Form data
        const formData = new FormData(form);

        // AJAX request
        fetch('/classes-store', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Handle success
                console.log(data);
                // Optionally, redirect or show a success message
            })
            .catch(error => {
                // Handle errors
                console.error('There was a problem with the fetch operation:', error);
                // Optionally, display an error message to the user
            });
    });
});