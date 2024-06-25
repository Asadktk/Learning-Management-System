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

                            <button id="toggleNonActiveButton" class="btn btn-primary">Show Non-Active Courses</button>

                            <table class="table table-borderless table-striped table-earning">
                                <thead>
                                    <tr>
                                    <tr>
                                        <th>Course Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Course Fee</th>
                                        <th> Operation</th>

                                        <!-- <th> <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                         <i class="zmdi zmdi-plus"></i>add item</button></th> -->
                                        <!--  <th class="text-right">quantity</th>
                                        <th class="text-right">total</th> -->
                                    </tr>
                                </thead>
                                <tbody id="coursesTableBody">
                                    <?php if (!empty($courses)) : ?>
                                        <?php foreach ($courses as $course) : ?>
                                            <tr id="course-<?= $course['id']; ?>" class="<?= ($course['deleted_at'] === null) ? 'active-course' : 'non-active-course'; ?>">
                                                <td><?= $course['title'] ?></td>
                                                <td><?= $course['start_date'] ?></td>
                                                <td><?= $course['end_date'] ?></td>
                                                <td><?= $course['fee'] ?></td>
                                                <th>
                                                    <a class="btn btn-success btn-sm" href="/admin/course/edit/<?= $course['id']; ?>">Edit</a>
                                                    <a class="btn btn-primary btn-sm" href="/admin/course/show/<?= $course['id']; ?>">View</a>
                                                    <a class="btn btn-danger btn-sm btn-delete text-white" onclick="deleteCourse(<?= $course['id']; ?>)">Delete</a>

                                                    <?php if ($course['deleted_at'] === null) : ?>
                                                        <a class="btn btn-warning btn-sm btn-block" href="/admin/course/block/<?= $course['id']; ?>" onclick="return confirm('Are you sure you want to block this course?');">Block</a>

                                                    <?php else : ?>
                                                        <a class="btn btn-success btn-sm btn-unblock" href="/admin/course/unblock/<?= $course['id']; ?>" onclick="return confirm('Are you sure you want to unblock this course?');">Unblock</a>
                                                    <?php endif; ?>


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


    // soft delete courses functionality
    function loadCourse(showNonActive) {
        $.ajax({
            url: `/courses/fetch?active=${!showNonActive}`,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                const $tableBody = $('#coursesTableBody');
                $tableBody.empty();

                $.each(data, function(index, course) {
                    const trClass = course.deleted_at === null ? 'active-course' : 'non-active-course';
                    const blockUnblockButton = course.deleted_at === null ?
                        `<a class="btn btn-warning btn-sm btn-block" href="#" data-id="${course.id}" data-action="block">Block</a>` :
                        `<a class="btn btn-success btn-sm btn-unblock" href="#" data-id="${course.id}" data-action="unblock">Unblock</a>`;

                    const tr = `
                    <tr class="${trClass}">
                        <td>${course.title}</td>
                        <td>${course.start_date}</td>
                        <td>${course.end_date}</td>
                        <td>${course.fee}</td>

                        <td>
                            <a class="btn btn-primary btn-sm" href="/admin/course/show/${course.id}">View</a>
                            <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="${course.id}" data-action="delete">Delete</a>
                            ${blockUnblockButton}
                        </td>
                    </tr>
                `;
                    $tableBody.append(tr);
                });

                $('#toggleNonActiveButton').text(showNonActive ? 'Show Active Courses' : 'Show Non-Active Courses');
            },
            error: function(error) {
                console.error('Error fetching courses:', error);
            }
        });
    }

    $(document).ready(function() {
        let showNonActive = false;

        $('#toggleNonActiveButton').on('click', function() {
            showNonActive = !showNonActive;
            loadCourse(showNonActive);
        });

        $('#coursesTableBody').on('click', 'a[data-action]', function(e) {
            e.preventDefault();
            const action = $(this).data('action');
            const id = $(this).data('id');
            let confirmMessage;

            if (action === 'delete') {
                confirmMessage = 'Are you sure you want to permanently delete this course?';
            } else if (action === 'block') {
                confirmMessage = 'Are you sure you want to block this course?';
            } else if (action === 'unblock') {
                confirmMessage = 'Are you sure you want to unblock this course?';
            }

            if (confirm(confirmMessage)) {
                $.ajax({
                    url: `/admin/course/${action}/${id}`,
                    method: 'GET',
                    success: function() {
                        loadCourse(showNonActive);
                    },
                    error: function(error) {
                        console.error(`Error during ${action} action:`, error);
                    }
                });
            }
        });

        // Initial load of active courses
        loadCourse(showNonActive);
    });
</script>


<?php require base_path('views/partials/footer.php') ?>