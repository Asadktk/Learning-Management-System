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


                    <div id="updateStatus"></div>

                    <form id='updateProfileForm'  method="post" >
                        <!-- <input type="hidden" name="_method" value="PUT" /> -->

                        <div class="form-group">
                            <label for="name">User Name</label>
                            <input type="text" id="name" name="name" class="form-control mb-3" value="<?= htmlspecialchars($studentDetails['name']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email" class="form-control mb-3" value="<?= htmlspecialchars($studentDetails['email']) ?>" readonly>
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#updateProfileForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '/update-profile',
                type: 'POST', 
                data: $(this).serialize(),
                dataType: 'json', 
                success: function(response) {
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    } else {
                        $('#updateStatus').html('<div class="alert alert-success">' + response.message + '</div>');
                    }
                },
                error: function(xhr) {
                    var response = xhr.responseJSON;
                    $('#updateStatus').html('<div class="alert alert-danger">' + response.error + '</div>');
                }
            });
        });
    });
</script>



<?php require base_path('views/frontend/partials/footer.php') ?>