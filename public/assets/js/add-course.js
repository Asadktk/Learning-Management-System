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
            },
            success: function(response) {
                if (response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX request failed:', error);
                alert('Error: ' + error);
            },
            complete: function() {
                $('#submit-button').attr('disabled', false);
                $('#payment-button-sending').hide();
            }
        });
    });
});














// $(document).ready(function() {
//     $('#course-form').on('submit', function(event) {
//         event.preventDefault();

//         // Serialize the form data
//         var formData = $(this).serializeArray();

//         // Get selected instructor IDs from the multi-select dropdown
//         var instructorIds = $('#instructors').val();

//         // Remove existing instructor_ids from formData if any
//         formData = formData.filter(function(item) {
//             return item.name !== 'instructor_ids[]';
//         });

//         // Add each selected instructor ID to the form data
//         $.each(instructorIds, function(index, value) {
//             formData.push({ name: 'instructor_ids[]', value: value });
//         });

//         var courseId = $('#course-id').val(); // Assuming there's a hidden input with id="course-id"
//         var url = courseId ? '/admin/course/update/' + courseId : '/admin/course/store';
//         var method = courseId ? 'POST' : 'POST'; // Using POST for both create and update

//         $.ajax({
//             url: url,
//             type: method,
//             data: formData,
//             dataType: 'json',
//             beforeSend: function() {
//                 $('#submit-button').attr('disabled', true);
//                 $('#payment-button-sending').show();
//                 console.log(formData);
//             },
//             success: function(response) {
//                 // Handle successful response
//                 if (response.redirect) {
//                     window.location.href = response.redirect;
//                 } else {
//                     alert(response.message);
//                 }
//             },
//             error: function(xhr, status, error) {
//                 // Handle errors
//                 console.error('AJAX request failed:', error);
//                 alert('Error: ' + error);
//             },
//             complete: function() {
//                 // Hide loading spinner or enable form elements if needed
//                 $('#submit-button').attr('disabled', false);
//                 $('#payment-button-sending').hide();
//             }
//         });
//     });
// });