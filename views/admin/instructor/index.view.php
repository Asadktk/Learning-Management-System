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
                                <tbody>
                                    <?php foreach ($instructors as $instructor) : ?>
                                        <tr class="<?= ($instructor['deleted_at'] === null) ? 'active-instructor' : 'non-active-instructor'; ?>">
                                            <td><?= $instructor['user_id'] ?></td>
                                            <td><?= $instructor['name'] ?></td>
                                            <td><?= $instructor['email'] ?></td>
                                            <td>
                                                <a class="btn btn-success btn-sm" href="/admin/instructor/edit/<?= $instructor['id']; ?>">Edit</a>
                                                <a class="btn btn-primary btn-sm" href="/admin/instructor/show/<?= $instructor['id']; ?>">View</a>
                                                <a class="btn btn-danger btn-sm btn-delete" href="/admin/instructor/destroy/<?= $instructor['id']; ?>">Delete</a>
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
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('toggleNonActiveButton').addEventListener('click', function() {
            var activeInstructors = document.querySelectorAll('.active-instructor');
            activeInstructors.forEach(function(instructor) {
                instructor.style.display = 'none';
            });
            var nonActiveInstructors = document.querySelectorAll('.non-active-instructor');
            nonActiveInstructors.forEach(function(instructor) {
                instructor.style.display = 'table-row';
            });
            // Change button text and functionality
            this.textContent = 'Show Active Instructors';
            this.removeEventListener('click', arguments.callee);
            this.addEventListener('click', function() {
                activeInstructors.forEach(function(instructor) {
                    instructor.style.display = 'table-row';
                });
                nonActiveInstructors.forEach(function(instructor) {
                    instructor.style.display = 'none';
                });
                // Reset button text and functionality
                this.textContent = 'Show Non-Active Instructors';
                this.removeEventListener('click', arguments.callee);
                this.addEventListener('click', function() {
                    // Call this function again to toggle
                    arguments.callee();
                });
            });
        });
    });
</script>

<?php require base_path('views/partials/footer.php') ?>