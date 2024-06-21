
<?php require base_path('views/frontend/partials/head.php') ?>

<?php require base_path('views/frontend/partials/header.php') ?>


<main class="main">

    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1>Student Profile</h1>
                        <p class="mb-0"> Profile View</p>
                    </div>
                </div>
            </div>
        </div>
        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="index.html">Profile</a></li>
                    <li class="current">Update Profile</li>
                </ol>
            </div>
        </nav>
    </div><!-- End Page Title -->

    <!-- Courses Course Details Section -->
    <!-- /Courses Course Details Section -->
    <section id="courses-course-details" class="courses-course-details section">

        <div class="container" data-aos="fade-up">

            <div class="row">
                <div class="col-lg-12">
                    <div class="container">
                        <?php if (isset($_SESSION['error'])) : ?>
                            <?php if ($_SESSION['error'] === 'no_seats_available') : ?>
                                <div class="alert alert-danger" role="alert">
                                    There are no available seats for this course at the moment.
                                </div>
                            <?php elseif ($_SESSION['error'] === 'already_enrolled') : ?>
                                <div class="alert alert-danger" role="alert">
                                    You are already enrolled in this course.
                                </div>
                            <?php endif; ?>
                            <?php unset($_SESSION['error']); ?>
                        <?php elseif (isset($_SESSION['success']) && $_SESSION['success'] === 'enrollment_success') : ?>
                            <div class="alert alert-success" role="alert">
                                You have successfully enrolled in the course.
                            </div>
                            <?php unset($_SESSION['success']); ?>
                        <?php endif; ?>

                    </div>


                    <form action="" method="post">
                        <div class="form-group">
                            <label for="name">User Name</label>
                            <input type="text" id="name" name="name" class="form-control  mb-3" value="<?=$studentDetails['name'] ?>" >
                            
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email" class="form-control mb-3" value="<?= $studentDetails['email'] ?>">
                        </div>


                        <!-- enroll cta -->
                        <input type="submit" class="btn btn-primary" value="Update" style="width: 100%;">
                    </form>


                    <a href="/" class="btn btn-primary mt-3">Back to Courses</a>

                </div>
            </div>



        </div>

    </section>

</main>
<?php require base_path('views/frontend/partials/footer.php') ?>