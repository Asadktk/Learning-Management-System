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
                            <?php if (empty($student['classes'])) : ?>
                                <div class="alert alert-info" role="alert">
                                    There are no courses for this student.
                                </div>
                                <a href="/admin/students" class="btn btn-primary">Back to students</a>
                            <?php else : ?>
                                <?php foreach ($student['classes'] as $class) : ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <p>User Name: <?= $student['user_name'] ?></p>
                                            <p>User Email: <?= $student['user_email'] ?></p>
                                            <p>Course Name: <?= $class['course']['title'] ?></p>
                                            <p>Course Description: <?= $class['course']['description'] ?></p>
                                            <p>Fee: <?= $class['course']['fee'] ?></p>
                                            <p>Available Seats: <?= $class['course']['available_seat'] ?></p>
                                            <p>Start Date: <?= $class['course']['start_date'] ?></p>
                                            <p>End Date: <?= $class['course']['end_date'] ?></p>
                                            <p>Instructor Name: <?= $class['instructor_name'] ?></p>
                                            <p>Instructor Email: <?= $class['instructor_email'] ?></p>
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