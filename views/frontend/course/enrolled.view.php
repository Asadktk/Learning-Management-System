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
                    <div class="container">
                        <?php if (isset($_SESSION['error'])) : ?>
                            <?php if ($_SESSION['error'] === 'no_seats_available') : ?>
                                <div class="alert alert-danger" role="alert">
                                    There are no available seats for this course at the moment.
                                </div>
                            <?php elseif ($_SESSION['error'] === 'already_enrolled') : ?>
                                <div class="alert alert-danger" role="alert">
                                    You are already enrolled in this course.
                                </div>
                            <?php endif; ?>
                            <?php unset($_SESSION['error']); ?>
                        <?php elseif (isset($_SESSION['success']) && $_SESSION['success'] === 'enrollment_success') : ?>
                            <div class="alert alert-success" role="alert">
                                You have successfully enrolled in the course.
                            </div>
                            <?php unset($_SESSION['success']); ?>
                        <?php endif; ?>

                    </div>


                    <form action="/course-enroll/<?= htmlspecialchars($course['id']); ?>" method="post">
                        <div class="form-group">
                            <label for="instructor_id">Trainer</label>
                            <select id="instructor_id" name="instructor_id" class="form-control  mb-3">
                                <?php
                                $instructorIds = $course['instructor_ids'] ?? [];
                                $instructorNames = $course['instructor_names'] ?? [];
                                if (!empty($instructorIds) && !empty($instructorNames)) {
                                    foreach (array_combine($instructorIds, $instructorNames) as $instructorId => $instructorName) {
                                        echo '<option value="' . htmlspecialchars($instructorId) . '">' . htmlspecialchars($instructorName) . '</option>';
                                    }
                                } else {
                                    echo '<option value="">Unknown Instructor</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="fee">Course Fee</label>
                            <input type="text" id="fee" name="fee" class="form-control  mb-3" value="<?= htmlspecialchars($course['fee'] ?? '0.00$'); ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="available_seat">Available Seats</label>
                            <input type="text" id="available_seat" name="available_seat" class="form-control  mb-3" value="<?= htmlspecialchars($availableSeats ?? '00'); ?>" readonly> <!-- Display available seats here -->
                        </div>

                        <div class="form-group">
                            <label for="schedule">Schedule</label>
                            <input type="text" id="schedule" name="schedule" class="form-control  mb-3" value="<?php
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
                    <a href="/" class="btn btn-primary mt-3">Back to Courses</a>

                </div>
            </div>



        </div>

    </section>

</main>
<?php require base_path('views/frontend/partials/footer.php') ?>