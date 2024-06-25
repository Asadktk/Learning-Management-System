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
                            <form action="/create-request" method="POST">
                                <div class="form-group">
                                    <select id="courses" name="course_id" class="form-control"> <!-- Added name="course_id" -->
                                        <?php foreach ($courses as $course) : ?>
                                            <option value="<?= $course['id']; ?>">
                                                <?= $course['title']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                    <button type="submit" class="btn btn-primary">Send Request</button>
                                </div>
                            </form>

                        </div>
                        <a href="/instructor/enrolled/student" class="btn btn-secondary">Back to Enrolled Students</a>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
    <!-- END PAGE CONTAINER-->
</div>




<?php require base_path('views/partials/footer.php') ?>