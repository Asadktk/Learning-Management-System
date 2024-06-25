<?php require base_path('views/frontend/partials/head.php') ?>

<?php require base_path('views/frontend/partials/header.php') ?>


<main class="main">

    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1>Student Profile</h1>
                        <p class="mb-0"> Profile View</p>
                    </div>
                </div>
            </div>
        </div>
        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="index.html">Profile</a></li>
                    <li class="current">Update Profile</li>
                </ol>
            </div>
        </nav>
    </div><!-- End Page Title -->

    <!-- Courses Course Details Section -->
    <!-- /Courses Course Details Section -->
    <section id="courses-course-details" class="courses-course-details section">

        <div class="container" data-aos="fade-up">

            <div class="row">
                <div class="col-lg-12">


                    <div id="updateStatus"></div>

                    <div style="font-family: Arial, sans-serif; background-color: #f2f2f2; padding: 20px;">
                        <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
                            <?php foreach ($courses as $course) : ?>
                                <div style="background-color: #ffffff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 8px; overflow: hidden; width: 300px; padding: 20px; transition: transform 0.3s ease; cursor: pointer;">
                                    <div style="font-size: 1.3rem; font-weight: bold; margin-bottom: 10px;"><?= htmlspecialchars($course['course_title']) ?></div>
                                    <div style="font-size: 0.9rem; color: #666666; margin-bottom: 15px;">
                                        <strong>Instructor:</strong> <?= htmlspecialchars($course['instructor_username']) ?><br>
                                        <strong>Email:</strong> <a href="mailto:<?= htmlspecialchars($course['instructor_email']) ?>" style="color: #3498db; text-decoration: none;"><?= htmlspecialchars($course['instructor_email']) ?></a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>


                    <a href="/" class="btn btn-primary mt-3">Back to Courses</a>

                </div>
            </div>



        </div>

    </section>

</main>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#updateProfileForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '/update-profile',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    } else {
                        $('#updateStatus').html('<div class="alert alert-success">' + response.message + '</div>');
                    }
                },
                error: function(xhr) {
                    var response = xhr.responseJSON;
                    $('#updateStatus').html('<div class="alert alert-danger">' + response.error + '</div>');
                }
            });
        });
    });
</script>



<?php require base_path('views/frontend/partials/footer.php') ?>