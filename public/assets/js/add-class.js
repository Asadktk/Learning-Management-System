$(document).ready(function() {

    $('#class-form').on('submit', function(event) {

        event.preventDefault();

        const userId = $('#user_id').val();
        const formData = new FormData(this);
        formData.append('user_id', userId);

        const classIdElement = $('#class_id');
        const isUpdateOperation = classIdElement.length > 0 && classIdElement.val() !== '';

        const url = isUpdateOperation ? `/classes-update/${classIdElement.val()}` : '/classes-store';

        const method = isUpdateOperation ? 'PUT' : 'POST';
        $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false,
            contentType: false,

            beforeSend: function() {
                $('#submit-button').attr('disabled', true);
                $('.text-danger').remove();
            },

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
                console.error('AJAX request failed:', error);
                console.log(xhr.responseJSON);
                if (xhr.status === 422) {
                    var responseData = xhr.responseJSON;
                    if (responseData.errors) {
                        var errors = responseData.errors;
                        for (var field in errors) {
                            if (errors.hasOwnProperty(field)) {
                                var errorMessage = '<p class="text-danger text-xs mt-2">' + errors[field] + '</p>';
                                $('[name="' + field + '"]').after(errorMessage);
                            }
                        }
                    } else if (responseData.error) {
                        var generalErrorMessage = '<div class="alert alert-danger mt-2">' + responseData.error + '</div>';
                        $('#error-message-container').html(generalErrorMessage);
                    }
                } else {
                    alert('Error: ' + error);
                }
            }



        });
    });
});