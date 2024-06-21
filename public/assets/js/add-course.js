$(document).ready(function() {
    $('#course-form').on('submit', function(event) {
        event.preventDefault();

        var formData = $(this).serializeArray();

        var instructorIds = $('#instructors').val();

        formData = formData.filter(function(item) {
            return item.name !== 'instructor_ids[]';
        });

        $.each(instructorIds, function(index, value) {
            formData.push({ name: 'instructor_ids[]', value: value });
        });

        console.log(formData);
        var courseId = $('#course-id').val();
        var url = courseId ? '/admin/course/update/' + courseId : '/admin/course/store';
        var method = courseId ? 'POST' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                $('#submit-button').attr('disabled', true);
                $('#payment-button-sending').show();
                $('.text-danger').remove();
            },
            success: function(response) {
                if (response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                if (xhr.status === 422) { // Validation error
                    var errors = xhr.responseJSON.errors;
                    for (var field in errors) {
                        if (errors.hasOwnProperty(field)) {
                            var fieldElement = $('[name="' + field + '"]');
                            if (fieldElement.length > 0) {
                                fieldElement.after('<p class="text-danger text-xs mt-2">' + errors[field] + '</p>');
                            } else if (field === 'instructor_ids') {
                                $('#instructors').after('<p class="text-danger text-xs mt-2">' + errors[field] + '</p>');
                            }
                        }
                    }
                } else {
                    console.error('AJAX request failed:', error);
                    alert('Error: ' + error);
                }
            },
            complete: function() {
                $('#submit-button').attr('disabled', false);
                $('#payment-button-sending').hide();
            }
        });
    });
});