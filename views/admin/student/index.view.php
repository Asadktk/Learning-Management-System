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

                        <!-- <button class="mb-4 au-btn au-btn-icon au-btn--green au-btn--small">
                        <i class="zmdi zmdi-plus"></i>add item</button> -->
                         <a class="mb-4 au-btn au-btn-icon au-btn--green au-btn--small" href="/students/create">Add Student</a>

                            <table class="table table-borderless table-striped table-earning">
                                <thead>
                                    <tr>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                         <th> Operation</th>
                                         
                                         <!-- <th> <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                         <i class="zmdi zmdi-plus"></i>add item</button></th> -->
                                      <!--  <th class="text-right">quantity</th>
                                        <th class="text-right">total</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students  as $student) : ?>
                                        <tr>
                                            <td><?= $student['user_id'] ?></td>
                                            <td><?= $student['name'] ?></td>
                                            <td><?= $student['email'] ?></td>
                                            <th> <a class="au-btn au-btn-icon au-btn--green au-btn--small" href="/students/create">Edit</a></th>

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