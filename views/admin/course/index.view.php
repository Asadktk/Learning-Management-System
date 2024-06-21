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
                            <a class="mb-4 au-btn au-btn-icon au-btn--green au-btn--small" href="/admin/courses/create">Add Course</a>
                           
                           
                            <?php require base_path('views/partials/messages.php') ?>

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
                                    <?php if (!empty($courses)) : ?>
                                        <?php foreach ($courses as $course) : ?>
                                            <tr id="course-<?= $course['id']; ?>">
                                                <td><?= $course['title'] ?></td>
                                                <td><?= $course['start_date'] ?></td>
                                                <td><?= $course['end_date'] ?></td>
                                                <th>
                                                    <a class="btn btn-success btn-sm" href="/admin/course/edit/<?= $course['id']; ?>">Edit</a>
                                                    <a class="btn btn-primary btn-sm" href="/admin/course/show/<?= $course['id']; ?>">View</a>
                                                    <a class="btn btn-danger btn-sm btn-delete text-white" onclick="deleteCourse(<?= $course['id']; ?>)">Delete</a>


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

<script>
    function deleteCourse(courseId) {
        if (confirm('Are you sure you want to delete this course?')) {
            $.ajax({
                url: '/admin/course/destroy/' + courseId,
                type: 'GET',
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                    } else {
                        alert(response.message);
                        $('#course-' + courseId).remove();
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + xhr.responseText);
                }
            });
        }
    }
</script>


<?php require base_path('views/partials/footer.php') ?>