<header id="header" class="header d-flex align-items-center sticky-top">
  <div class="container-fluid container-xl position-relative d-flex align-items-center">

    <a href="/" class="logo d-flex align-items-center me-auto">
      <!-- Uncomment the line below if you also wish to use an image logo -->
      <!-- <img src="assets/img/logo.png" alt=""> -->
      <h1 class="sitename">Mentor</h1>
    </a>

    <nav id="navmenu navbar-expand-lg" class="navmenu">
      <ul>
        <li><a href="/" class="active">Home<br></a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="courses.html">Courses</a></li>
        <li><a href="trainers.html">Trainers</a></li>

        <li><a href="contact.html">Contact</a></li>
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>
    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'student') : ?>


      <form action="/logout" method="POST">

        <input type="hidden" name="_method" value="DELETE" />
        <button class="btn-getstarted border-0">Log Out</button>
      </form>
      <a class="btn-getstarted" href="/student-frofile">View Profile</a>
      

    <?php else : ?>

      <a class="btn-getstarted" href="/login">Get Started</a>

    <?php endif ?>
  </div>
</header>