$(document).ready(function() {

    $('#class-form').on('submit', function(event) {

        event.preventDefault();

        const startTime = $('#start_time').val();
        const endTime = $('#end_time').val();

        if (startTime >= endTime) {
            alert('Start time must be less than end time');
            return;
        }

        const userId = $('#user_id').val();
        const formData = new FormData(this);
        formData.append('user_id', userId);

        const classIdElement = $('#class_id');
        const isUpdateOperation = classIdElement.length > 0 && classIdElement.val() !== '';

        const url = isUpdateOperation ? `/classes-update/${classIdElement.val()}` : '/classes-store';
        const method = 'POST';

        $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false,
            contentType: false,

            success: function(data) {
                console.log('Raw response:', data);
                if (data.redirect) {
                    window.location.href = data.redirect + '?message=' + encodeURIComponent(data.message);
                } else if (data.message) {
                    alert(data.message);
                } else {
                    alert('No message returned from the server.');
                }
            },
            error: function(xhr, status, error) {
                console.error('There was a problem with the AJAX request:', error);
                alert('Error: ' + error);
            }
        });
    });
});