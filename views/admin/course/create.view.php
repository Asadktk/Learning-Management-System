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
                            <div class="card-header">Create Course</div>
                            <div class="card-body">
                                <div class="card-title">
                                    <h3 class="text-center title-2">Course</h3>
                                </div>
                                <hr>
                            <?php require base_path('views/partials/messages.php') ?>

                                <form id="course-form" action="/admin/course/store" method="POST">



                                    <div class="form-group">


                                        <select id="instructors" name="instructor_ids[]" multiple class="form-control">
                                            <?php foreach ($instructors as $instructor) : ?>
                                                <option value="<?php echo $instructor['id']; ?>"><?php echo $instructor['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>

                                        <?php if (isset($errors['instructor_ids'])) : ?>
                                            <p class="text-danger text-xs mt-2"><?= htmlspecialchars($errors['instructor_ids']) ?></p>
                                        <?php endif; ?>
                                    </div>


                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Courses Title</label>
                                        <input type="text" id="title" name="title" class="form-control">

                                        <?php if (isset($errors['title'])) : ?>
                                            <p class="text-danger text-xs mt-2"><?= htmlspecialchars($errors['title']) ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Courses Description</label>
                                        <textarea name="description" id="description" rows="9" placeholder="Content..." class="form-control"></textarea>

                                        <?php if (isset($errors['description'])) : ?>
                                            <p class="text-danger text-xs mt-2"><?= htmlspecialchars($errors['description']) ?></p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label mb-1">Fee</label>
                                                <input id="fee" name="fee" type="number" class="form-control">
                                                <span class="help-block" data-valmsg-for="cc-exp" data-valmsg-replace="true"></span>

                                                <?php if (isset($errors['fee'])) : ?>
                                                    <p class="text-danger text-xs mt-2"><?= htmlspecialchars($errors['fee']) ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-exp" class="control-label mb-1">Available Seat</label>
                                                <input id="available_seat" name="available_seat" type="number" class="form-control">
                                                <span class="help-block" data-valmsg-for="cc-exp" data-valmsg-replace="true"></span>

                                                <?php if (isset($errors['available_seat'])) : ?>
                                                    <p class="text-danger text-xs mt-2"><?= htmlspecialchars($errors['available_seat']) ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="start_date" class="control-label mb-1">Start Date</label>
                                                <input id="start_date" name="start_date" type="date" class="form-control">
                                                <span class="help-block" data-valmsg-for="start_date" data-valmsg-replace="true"></span>

                                                <?php if (isset($errors['start_date'])) : ?>
                                                    <p class="text-danger text-xs mt-2"><?= htmlspecialchars($errors['start_date']) ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="end_date" class="control-label mb-1">End Date </label>
                                                <input id="end_date" name="end_date" type="date" class="form-control">
                                                <span class="help-block" data-valmsg-for="end_date" data-valmsg-replace="true"></span>

                                                <?php if (isset($errors['end_date'])) : ?>
                                                    <p class="text-danger text-xs mt-2"><?= htmlspecialchars($errors['end_date']) ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <button id="submit-button" type="submit" class="btn btn-lg btn-info btn-block">
                                            <span id="course-create">Create</span>
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

<script src="/assets/js/add-course.js"></script>


<?php require base_path('views/partials/footer.php') ?>