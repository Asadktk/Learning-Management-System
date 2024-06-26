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
                        <div class="card">
                            <div class="card-header">Create Class</div>
                            <div class="card-body">
                                <div class="card-title">
                                    <h3 class="text-center title-2">Class</h3>
                                </div>
                                <hr>
                                <form id="class-form" novalidate="novalidate">
                                    <div class="form-group">
                                        <label for="course-select" class="control-label mb-1">Courses</label>
                                        <select id="course-select" class="form-control" disabled>
                                            <option value="0">Please select</option>
                                            <?php foreach ($courses as $course) : ?>
                                                <option value="<?= $course['id']; ?>" <?= $course['id'] == $courseClass['course_id'] ? 'selected' : ''; ?>>
                                                    <?= $course['title']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="start_time" class="control-label mb-1">Start Time</label>
                                                <input id="start_time" type="time" class="form-control" value="<?= $courseClass['start_time']; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="end_time" class="control-label mb-1">End Time</label>
                                                <input id="end_time" type="time" class="form-control" value="<?= $courseClass['end_time']; ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button id="redirect-button" type="button" class="btn btn-lg btn-info btn-block">Back to Index</button>
                                    </div>
                                </form>


                            </div>
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
        // Add event listener to the redirect button
        const redirectButton = document.getElementById('redirect-button');
        redirectButton.addEventListener('click', function() {
            window.location.href = '/classes-index'; // Redirect to the index page
        });
    });
</script>

<?php require base_path('views/partials/footer.php') ?>