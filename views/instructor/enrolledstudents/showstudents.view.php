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
                            <table class="table table-borderless table-striped table-earning">
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Student Name</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <!-- Add more headers if needed -->
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    if (isset($enrolledStudents) && !empty($enrolledStudents)) {
                                        foreach ($enrolledStudents as $student) {
                                            echo '<tr>';
                                            echo '<td>' . htmlspecialchars($student['id']) . '</td>';
                                            echo '<td>' . htmlspecialchars($student['student_name']) . '</td>';
                                            echo '<td>' . htmlspecialchars($student['created_at']) . '</td>';
                                            echo '<td>' . htmlspecialchars($student['updated_at']) . '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="4">No students enrolled for this course.</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <a class="btn btn-primary mt-3" href="/instructor/enrolled/student">Go Back</a>

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
