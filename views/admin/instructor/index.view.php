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
                            <button id="toggleNonActiveButton" class="btn btn-primary">Show Non-Active Instructors</button>
                            <table id="instructorsTable" class="table table-borderless table-striped table-earning">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Operation</th>
                                    </tr>
                                </thead>
                                <tbody id="instructorsTableBody">
                                    <?php foreach ($instructors as $instructor) : ?>
                                        <tr class="<?= ($instructor['deleted_at'] === null) ? 'active-instructor' : 'non-active-instructor'; ?>">
                                            <td><?= $instructor['user_id'] ?></td>
                                            <td><?= $instructor['name'] ?></td>
                                            <td><?= $instructor['email'] ?></td>
                                            <td>
                                                <a class="btn btn-success btn-sm" href="/admin/instructor/edit/<?= $instructor['id']; ?>">Edit</a>
                                                <a class="btn btn-primary btn-sm" href="/admin/instructor/show/<?= $instructor['id']; ?>">View</a>
                                                <a class="btn btn-danger btn-sm btn-delete" href="/admin/instructor/destroy/<?= $instructor['id']; ?>" onclick="return confirm('Are you sure you want to permanently delete this instructor?');">Delete</a>
                                                <?php if ($instructor['deleted_at'] === null) : ?>
                                                    <a class="btn btn-warning btn-sm btn-block" href="/admin/instructor/block/<?= $instructor['id']; ?>" onclick="return confirm('Are you sure you want to block this instructor?');">Block</a>

                                                <?php else : ?>
                                                    <a class="btn btn-success btn-sm btn-unblock" href="/admin/instructor/unblock/<?= $instructor['id']; ?>" onclick="return confirm('Are you sure you want to unblock this instructor?');">Unblock</a>
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
        function loadInstructors(showNonActive) {
            $.ajax({
                url: `/instructors/fetch?active=${!showNonActive}`,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    const $tableBody = $('#instructorsTableBody');
                    $tableBody.empty();

                    $.each(data, function(index, instructor) {
                        const trClass = instructor.deleted_at === null ? 'active-instructor' : 'non-active-instructor';
                        const blockUnblockButton = instructor.deleted_at === null 
                            ? `<a class="btn btn-warning btn-sm btn-block" href="#" data-id="${instructor.id}" data-action="block">Block</a>`
                            : `<a class="btn btn-success btn-sm btn-unblock" href="#" data-id="${instructor.id}" data-action="unblock">Unblock</a>`;

                        const tr = `
                            <tr class="${trClass}">
                                <td>${instructor.user_id}</td>
                                <td>${instructor.name}</td>
                                <td>${instructor.email}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="/admin/instructor/show/${instructor.id}">View</a>
                                    <a class="btn btn-danger btn-sm btn-delete" href="#" data-id="${instructor.id}" data-action="delete">Delete</a>
                                    ${blockUnblockButton}
                                </td>
                            </tr>
                        `;
                        $tableBody.append(tr);
                    });

                    $('#toggleNonActiveButton').text(showNonActive ? 'Show Active Instructors' : 'Show Non-Active Instructors');
                },
                error: function(error) {
                    console.error('Error fetching instructors:', error);
                }
            });
        }

        $(document).ready(function() {
            let showNonActive = false;

            $('#toggleNonActiveButton').on('click', function() {
                showNonActive = !showNonActive;
                loadInstructors(showNonActive);
            });

            $('#instructorsTableBody').on('click', 'a[data-action]', function(e) {
                e.preventDefault();
                const action = $(this).data('action');
                const id = $(this).data('id');
                let confirmMessage;

                if (action === 'delete') {
                    confirmMessage = 'Are you sure you want to permanently delete this instructor?';
                } else if (action === 'block') {
                    confirmMessage = 'Are you sure you want to block this instructor?';
                } else if (action === 'unblock') {
                    confirmMessage = 'Are you sure you want to unblock this instructor?';
                }

                if (confirm(confirmMessage)) {
                    $.ajax({
                        url: `/admin/instructor/${action}/${id}`,
                        method: 'GET',
                        success: function() {
                            loadInstructors(showNonActive);
                        },
                        error: function(error) {
                            console.error(`Error during ${action} action:`, error);
                        }
                    });
                }
            });

            // Initial load of active instructors
            loadInstructors(showNonActive);
        });
    </script>

<?php require base_path('views/partials/footer.php') ?>








