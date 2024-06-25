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
                            <table class="table table-borderless table-striped table-earning">
                                <thead>

                                    <tr>
                                        <th>Request ID</th>
                                        <th>Instructor Name</th>
                                        <th>Course Title</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($requests as $request) : ?>
                                        <tr>
                                            <td><?= htmlspecialchars($request['id']); ?></td>
                                            <td><?= htmlspecialchars($request['instructor_name']); ?></td>
                                            <td><?= htmlspecialchars($request['course_title']); ?></td>
                                            <td>
                                                
                                                    <form action="/approve-request" method="POST" style="display:inline;">
                                                        <input type="hidden" name="request_id" value="<?= htmlspecialchars($request['id']); ?>">
                                                        <button type="submit" class="btn btn-approve">Approve</button>
                                                    </form>
                                                    <form action="/reject-request" method="POST" style="display:inline;">
                                                        <input type="hidden" name="request_id" value="<?= htmlspecialchars($request['id']); ?>">
                                                        <button type="submit" class="btn btn-reject">Reject</button>
                                                    </form>
                                         
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>
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