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
                                <form id="class-form" method="post" novalidate="novalidate">
                                    <div class="form-group">
                                        <input type="hidden" id="user_id" name="user_id" value='<?php echo $_SESSION["user"]["id"]; ?>'>

                                        <label for="cc-payment" class="control-label mb-1">Courses</label>
                                        <select name="course_id" id="course-select" class="form-control">
                                            <option value="0">Please select</option>
                                            <?php foreach ($courses as $course) : ?>
                                                <option value="<?= $course['id']; ?>"><?= $course['title']; ?></option>
                                            <?php endforeach; ?>
                                        </select>

                                        <?php if (isset($errors['course_id'])) : ?>
                                            <p class="text-danger text-xs mt-2"><?= htmlspecialchars($errors['course_id']) ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label mb-1">Start Time</label>
                                                <input id="start_time" name="start_time" type="time" class="form-control">
                                                <span class="help-block" data-valmsg-for="cc-exp" data-valmsg-replace="true"></span>

                                                <?php if (isset($errors['start_time'])) : ?>
                                                    <p class="text-danger text-xs mt-2"><?= htmlspecialchars($errors['start_time']) ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label mb-1">End Time</label>
                                                <input id="end_time" name="end_time" type="time" class="form-control">
                                                <span class="help-block" data-valmsg-for="cc-exp" data-valmsg-replace="true"></span>

                                                <?php if (isset($errors['end_time'])) : ?>
                                                    <p class="text-danger text-xs mt-2"><?= htmlspecialchars($errors['end_time']) ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="error-message-container"></div>    
                                    <div>
                                        <button id="submit-button" type="submit" class="btn btn-lg btn-info btn-block">
                                            <span id="payment-button-amount">Create</span>
                                            <span id="payment-button-sending" style="display:none;">Sending…</span>
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


<script src="assets/js/add-class.js"></script>

<?php require base_path('views/partials/footer.php') ?>