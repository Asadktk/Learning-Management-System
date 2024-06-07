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
                            <table class="table table-borderless table-striped table-earning">
                                <thead>
                                    <tr>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <!-- <th class="text-right">Role</th>
                                        <th class="text-right">quantity</th>
                                        <th class="text-right">total</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($instructors  as $instructor) : ?>
                                        <tr>
                                            <td><?= $instructor['user_id'] ?></td>
                                            <td><?= $instructor['name'] ?></td>
                                            <td><?= $instructor['email'] ?></td>
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

<?php require base_path('views/partials/footer.php') ?>