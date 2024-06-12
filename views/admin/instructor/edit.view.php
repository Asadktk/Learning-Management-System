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
                            <!-- Assuming $instructor is fetched as shown in the previous code -->
                            <?php foreach ($instructor['classes'] as $class) : ?>
                                <div class="card">
                                    <div class="card-body">
                                        <p>User Name: <?= $class['user_name'] ?></p>
                                        <p>User Email: <?= $class['user_email'] ?></p>
                                        <p>Course Name: <?= $class['title'] ?></p>
                                        <p>Course Description: <?= $class['course_description'] ?></p>
                                        <p>Fee: <?= $class['fee'] ?></p>
                                        <p>Available Seats: <?= $class['available_seat'] ?></p>
                                        <p>Start Date: <?= $class['start_date'] ?></p>
                                        <p>End Date: <?= $class['end_date'] ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>

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