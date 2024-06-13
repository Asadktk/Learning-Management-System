$(document).ready(function() {
    $('#course-form').on('submit', function(event) {
        event.preventDefault();

        // Serialize form data including selected instructor IDs
        var formData = $(this).serializeArray();
        var instructorIds = $('#course-select').val(); // Assuming the select element has id="course-select"
        formData.push({ name: 'instructor_ids[]', value: instructorIds });

        var courseId = $('#course-id').val(); // Assuming there's a hidden input with id="course-id"
        var url = courseId ? '/admin/course/update/' + courseId : '/admin/course/store';
        var method = courseId ? 'POST' : 'POST'; // Using PUT for update, POST for create

        $.ajax({
            url: url,
            type: method,
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                $('#submit-button').attr('disabled', true);
                $('#payment-button-sending').show();
            },
            success: function(response) {
                // Handle successful response
                if (response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error('AJAX request failed:', error);
                alert('Error: ' + error);
            },
            complete: function() {
                // Hide loading spinner or enable form elements if needed
                $('#submit-button').attr('disabled', false);
                $('#payment-button-sending').hide();
            }
        });
    });
});