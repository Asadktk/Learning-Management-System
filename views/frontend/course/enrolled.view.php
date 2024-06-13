<?php require base_path('views/frontend/partials/head.php') ?>

<?php require base_path('views/frontend/partials/header.php') ?>


<main class="main">

    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1>Course Enrolled</h1>
                        <p class="mb-0"> <?= htmlspecialchars($course['description'] ?? 'Course Description'); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="index.html">Home</a></li>
                    <li class="current">Course Enrolled</li>
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
                    <form action="enroll.php" method="post">
                        <div class="form-group">
                            <label for="instructor_name">Trainer</label>
                            <input type="text" id="instructor_name" name="instructor_name" class="form-control" value="<?= htmlspecialchars($course['instructor_name'] ?? 'Unknown Instructor'); ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="fee">Course Fee</label>
                            <input type="text" id="fee" name="fee" class="form-control" value="<?= htmlspecialchars($course['fee'] ?? '0.00$'); ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="available_seat">Available Seats</label>
                            <input type="text" id="available_seat" name="available_seat" class="form-control" value="<?= htmlspecialchars($course['available_seat'] ?? '00'); ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="schedule">Schedule</label>
                            <input type="text" id="schedule" name="schedule" class="form-control" value="<?php
                                                                                                            if ($course['start_date'] && $course['end_date']) {
                                                                                                                echo date('F j, Y', strtotime($course['start_date'])) . ' - ' . date('F j, Y', strtotime($course['end_date']));
                                                                                                            } else {
                                                                                                                echo 'Schedule not available';
                                                                                                            }
                                                                                                            ?>" readonly>
                        </div>

                        <!-- enroll cta -->
                        <input type="submit" class="btn btn-primary" value="Enroll" style="width: 100%;">
                    </form>
                </div>
            </div>



        </div>

    </section>

</main>
<?php require base_path('views/frontend/partials/footer.php') ?>