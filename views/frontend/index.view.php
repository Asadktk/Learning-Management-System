<!-- HEADER DESKTOP-->
<?php require base_path('views/frontend/partials/head.php') ?>
<?php require base_path('views/frontend/partials/header.php') ?>

<!-- HEADER DESKTOP-->



<main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">

        <img src="frontend/assets/img/hero-bg.jpg" alt="" data-aos="fade-in">

        <div class="container">
            <h2 data-aos="fade-up" data-aos-delay="100">Learning Today,<br>Leading Tomorrow</h2>
            <p data-aos="fade-up" data-aos-delay="200">We are team of talented designers making websites with Bootstrap</p>
            <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
                <a href="courses.html" class="btn-get-started">Get Started</a>
            </div>
        </div>

    </section><!-- /Hero Section -->



    <!-- Courses Section -->
    <section id="courses" class="courses section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Courses</h2>
            <p>Popular Courses</p>
        </div><!-- End Section Title -->

        <div class="container">
            <div class="row">
                <?php foreach ($courses as $course) : ?>
                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                        <div class="course-item">
                            <img src="frontend/assets/img/course-1.jpg" class="img-fluid" alt="...">
                            <div class="course-content">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <p class="category"><?= htmlspecialchars($course['title']); ?></p>
                                    <p class="price">$<?= htmlspecialchars($course['fee']); ?></p>
                                </div>

                                <h3><a href="/course-show/<?= $course['id']; ?>"><?= htmlspecialchars($course['title']); ?></a></h3>
                                <p class="description"><?= htmlspecialchars($course['description']); ?></p>
                                <div class="trainer d-flex justify-content-between align-items-center">
                                    <div class="trainer-profile d-flex align-items-center">
                                        <img src="frontend/assets/img/trainers/trainer-1-2.jpg" class="img-fluid" alt="">
                                        <a href="" class="trainer-link"><?= htmlspecialchars($course['instructor_names']); ?></a>
                                    </div>
                                    <div class="trainer-rank d-flex align-items-center">
                                        <i class="bi bi-person user-icon"></i>&nbsp;<?= htmlspecialchars($course['available_seat']); ?>
                                        &nbsp;&nbsp;
                                        <i class="bi bi-heart heart-icon"></i>&nbsp;Likes
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End Course Item-->
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- /Courses Section -->

     <!-- Counts Section -->
     <section id="counts" class="section counts">

<div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row gy-4">

        <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
                <span data-purecounter-start="0" data-purecounter-end="<?= $studentCount ?>" data-purecounter-duration="1" class="purecounter"></span>
                <p>Students</p>
            </div>
        </div><!-- End Stats Item -->

        <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
                <span data-purecounter-start="0" data-purecounter-end="<?= $courseCount ?>" data-purecounter-duration="1" class="purecounter"></span>
                <p>Courses</p>
            </div>
        </div><!-- End Stats Item -->

        <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
                <span data-purecounter-start="0" data-purecounter-end="<?= $eventCount ?>" data-purecounter-duration="1" class="purecounter"></span>
                <p>Classes</p>
            </div>
        </div><!-- End Stats Item -->

        <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
                <span data-purecounter-start="0" data-purecounter-end="<?= $trainerCount ?>" data-purecounter-duration="1" class="purecounter"></span>
                <p>Trainers</p>
            </div>
        </div><!-- End Stats Item -->

    </div>

</div>

</section><!-- /Counts Section -->

    <!-- Trainers Index Section -->
    <section id="trainers-index" class="section trainers-index">

        <div class="container">

            <div class="row">
                <?php foreach ($instructors as $instructors) : ?>
                    <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
                        <div class="member">
                            <img src="frontend/assets/img/trainers/trainer-1.jpg" class="img-fluid" alt="">
                            <div class="member-content">
                                <h4><?= htmlspecialchars($instructors['name']); ?></h4>
                                <span><?= htmlspecialchars($instructors['email']); ?></span>
                                <p>
                                    Magni qui quod omnis unde et eos fuga et exercitationem. Odio veritatis perspiciatis quaerat qui aut aut aut
                                </p>
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Team Member -->
                <?php endforeach; ?>
            </div>

        </div>

    </section><!-- /Trainers Index Section -->


   
</main>

<?php require base_path('views/frontend/partials/footer.php') ?>