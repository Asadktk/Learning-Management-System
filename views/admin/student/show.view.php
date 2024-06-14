<!-- PAGE CONTAINER-->

<?php require base_path('views/partials/head.php') ?>

<div class="page-container">
    <!-- HEADER DESKTOP-->
    <?php require base_path('views/partials/header.php') ?>

    <!-- HEADER DESKTOP-->
    <?php require base_path('views/partials/sidebar.php') ?>

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive table--no-card m-b-30">
                            <?php if (empty($student['courses'])) : ?>
                                <div class="alert alert-info" role="alert">
                                    There are no courses for this student.
                                </div>
                                <a href="/admin/students" class="btn btn-primary">Back to students</a>
                            <?php else : ?>
                                <div class="card">
                                    <div class="card-body">
                                        <p><b>Student Name: </b> <?= htmlspecialchars($student['user_name'], ENT_QUOTES, 'UTF-8') ?></p>
                                        <p><b>Student Email:</b>  <?= htmlspecialchars($student['user_email'], ENT_QUOTES, 'UTF-8') ?></p>
                                    </div>
                                </div>

                                <?php foreach ($student['courses'] as $course) : ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <p><b>Course Name: </b><?= htmlspecialchars($course['title'], ENT_QUOTES, 'UTF-8') ?></p>
                                            <p><b>Course Description:</b>  <?= htmlspecialchars($course['description'], ENT_QUOTES, 'UTF-8') ?></p>
                                            <p><b>Course Fee: </b> <?= htmlspecialchars($course['fee'], ENT_QUOTES, 'UTF-8') ?></p>
                                            <p><b>Available Seats:</b>  <?= htmlspecialchars($course['available_seat'], ENT_QUOTES, 'UTF-8') ?></p>
                                            <p><b>Start Date:</b>  <?= htmlspecialchars($course['start_date'], ENT_QUOTES, 'UTF-8') ?></p>
                                            <p><b>End Date:</b>  <?= htmlspecialchars($course['end_date'], ENT_QUOTES, 'UTF-8') ?></p>
                                            <p><b>Instructor Name: </b> <?= htmlspecialchars($course['instructor_name'], ENT_QUOTES, 'UTF-8') ?></p>
                                            <p><b>Instructor Email: </b> <?= htmlspecialchars($course['instructor_email'], ENT_QUOTES, 'UTF-8') ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                                <a href="/admin/students" class="btn btn-primary">Back to Students</a>
                            <?php endif; ?>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- END MAIN CONTENT-->
    <!-- END PAGE CONTAINER-->
</div>

<?php require base_path('views/partials/footer.php') ?>