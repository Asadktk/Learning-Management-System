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

                            <!-- <button class="mb-4 au-btn au-btn-icon au-btn--green au-btn--small">
                        <i class="zmdi zmdi-plus"></i>add item</button> -->
                            <a class="mb-4 au-btn au-btn-icon au-btn--green au-btn--small" href="/classes-create">Add Class</a>

                            <table class="table table-borderless table-striped table-earning">
                                <thead>
                                    <tr>
                                    <tr>
                                        <th>Course Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th> Operation</th>

                                        <!-- <th> <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                         <i class="zmdi zmdi-plus"></i>add item</button></th> -->
                                        <!--  <th class="text-right">quantity</th>
                                        <th class="text-right">total</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($classesWithCourses)) : ?>
                                        <?php foreach ($classesWithCourses as $classWithCourse) : ?>
                                            <tr>
                                                <td><?= $classWithCourse['course']['title'] ?></td>
                                                <td><?= $classWithCourse['start_time'] ?></td>
                                                <td><?= $classWithCourse['end_time'] ?></td>
                                                <th>
                                                    <a class="btn btn-success btn-sm" href="/classes-edit/<?= $classWithCourse['id']; ?>">Edit</a>
                                                    <a class="btn btn-primary btn-sm" href="/classes-show/<?= $classWithCourse['id']; ?>">View</a>
                                                    <a class="btn btn-danger btn-sm" href="/classes-destroy/<?= $classWithCourse['id']; ?>">Delete</a>
                                                </th>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="4">No classes available</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>

                            </table>
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