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
                            <div class="card-header">Update Course</div>
                            <div class="card-body">
                                <div class="card-title">
                                    <h3 class="text-center title-2">Course</h3>
                                </div>
                                <hr>
                                <form id="course-form" method="POST" novalidate="novalidate">
                                <!-- <input type="hidden" name="_method" value="PUT"> -->
                                    <div class="form-group">
                                    <input type="hidden" id="course-id" value="<?= $course['id'] ?? '' ?>">
                                        <label for="title" class="control-label mb-1">Course Title</label>
                                        <input type="text" id="title" name="title" class="form-control" value="<?= $course['title'] ?? '' ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="description" class="control-label mb-1">Course Description</label>
                                        <textarea name="description" id="description" rows="9" placeholder="Content..." class="form-control"><?= $course['description'] ?? '' ?></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="fee" class="control-label mb-1">Fee</label>
                                                <input id="fee" name="fee" type="number" class="form-control" value="<?= $course['fee'] ?? '' ?>">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="available_seat" class="control-label mb-1">Available Seat</label>
                                                <input id="available_seat" name="available_seat" type="number" class="form-control" value="<?= $course['available_seat'] ?? '' ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="start_date" class="control-label mb-1">Start Date</label>
                                                <input id="start_date" name="start_date" type="date" class="form-control" value="<?= $course['start_date'] ?? '' ?>">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="end_date" class="control-label mb-1">End Date</label>
                                                <input id="end_date" name="end_date" type="date" class="form-control" value="<?= $course['end_date'] ?? '' ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <button id="submit-button" type="submit" class="btn btn-lg btn-info btn-block">
                                            <span id="course-create">Update</span>
                                        </button>
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

<script src="/assets/js/add-course.js"></script>


<?php require base_path('views/partials/footer.php') ?>