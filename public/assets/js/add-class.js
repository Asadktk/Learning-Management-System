document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('class-form');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const startTime = document.getElementById('start_time').value;
        const endTime = document.getElementById('end_time').value;

        if (startTime >= endTime) {
            alert('Start time must be less than end time');
            return;
        }

        const userId = document.getElementById('user_id').value;
        const formData = new FormData(form);
        formData.append('user_id', userId);

        const classIdElement = document.getElementById('class_id');
        const isUpdateOperation = classIdElement !== null && classIdElement.value !== '';

        const url = isUpdateOperation ? `/classes-update/${classIdElement.value}` : '/classes-store';
        const method = isUpdateOperation ? 'POST' : 'POST';

        fetch(url, {
                method: method,
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
                if (data.redirect) {

                    if (!isUpdateOperation) {
                        window.location.href = data.redirect;
                    } else {
                        alert(data.message);
                    }
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
                alert('Error: ' + error.message);
            });
    });
});