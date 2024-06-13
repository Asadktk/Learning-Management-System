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
                            <button id="toggleNonActiveButton" class="btn btn-primary">Show Non-Active Students</button>
                            <table id="studentTable" class="table table-borderless table-striped table-earning">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Operation</th>
                                    </tr>
                                </thead>
                                <tbody id="studentsTableBody">
                                    <?php foreach ($students as $student) : ?>
                                        <tr class="<?= ($student['deleted_at'] === null) ? 'active-student' : 'non-active-student'; ?>">
                                            <td><?= $student['user_id'] ?></td>
                                            <td><?= $student['name'] ?></td>
                                            <td><?= $student['email'] ?></td>
                                            <td>
                                                <a class="btn btn-success btn-sm" href="/admin/student/edit/<?= $student['id']; ?>">Edit</a>
                                                <a class="btn btn-primary btn-sm" href="/admin/student/show/<?= $student['id']; ?>">View</a>
                                                <a class="btn btn-danger btn-sm btn-delete" href="/admin/student/destroy/<?= $student['id']; ?>" onclick="return confirm('Are you sure you want to permanently delete this student?');">Delete</a>
                                                <?php if ($student['deleted_at'] === null) : ?>
                                                    <a class="btn btn-warning btn-sm btn-block" href="/admin/student/block/<?= $student['id']; ?>" onclick="return confirm('Are you sure you want to block this student?');">Block</a>

                                                <?php else : ?>
                                                    <a class="btn btn-success btn-sm btn-unblock" href="/admin/student/unblock/<?= $student['id']; ?>" onclick="return confirm('Are you sure you want to unblock this student?');">Unblock</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
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
        function loadStudents(showNonActive) {
            $.ajax({
                url: `/students/fetch?active=${!showNonActive}`,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    const $tableBody = $('#studentsTableBody');
                    $tableBody.empty();

                    $.each(data, function(index, student) {
                        const trClass = student.deleted_at === null ? 'active-student' : 'non-active-student';
                        const blockUnblockButton = student.deleted_at === null 
                            ? `<a class="btn btn-warning btn-sm btn-block" href="#" data-id="${student.id}" data-action="block">Block</a>`
                            : `<a class="btn btn-success btn-sm btn-unblock" href="#" data-id="${student.id}" data-action="unblock">Unblock</a>`;

                        const tr = `
                            <tr class="${trClass}">
                                <td>${student.user_id}</td>
                                <td>${student.name}</td>
                                <td>${student.email}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="/admin/student/show/${student.id}">View</a>
                                    <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="${student.id}" data-action="delete">Delete</a>
                                    ${blockUnblockButton}
                                </td>
                            </tr>
                        `;
                        $tableBody.append(tr);
                    });

                    $('#toggleNonActiveButton').text(showNonActive ? 'Show Active students' : 'Show Non-Active students');
                },
                error: function(error) {
                    console.error('Error fetching students:', error);
                }
            });
        }

        $(document).ready(function() {
            let showNonActive = false;

            $('#toggleNonActiveButton').on('click', function() {
                showNonActive = !showNonActive;
                loadStudents(showNonActive);
            });

            $('#studentsTableBody').on('click', 'a[data-action]', function(e) {
                e.preventDefault();
                const action = $(this).data('action');
                const id = $(this).data('id');
                let confirmMessage;

                if (action === 'delete') {
                    confirmMessage = 'Are you sure you want to permanently delete this student?';
                } else if (action === 'block') {
                    confirmMessage = 'Are you sure you want to block this student?';
                } else if (action === 'unblock') {
                    confirmMessage = 'Are you sure you want to unblock this student?';
                }

                if (confirm(confirmMessage)) {
                    $.ajax({
                        url: `/admin/student/${action}/${id}`,
                        method: 'GET',
                        success: function() {
                            loadStudents(showNonActive);
                        },
                        error: function(error) {
                            console.error(`Error during ${action} action:`, error);
                        }
                    });
                }
            });

            // Initial load of active instructors
            loadStudents(showNonActive);
        });
    </script>

<?php require base_path('views/partials/footer.php') ?>








