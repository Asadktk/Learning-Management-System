<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="/admin-dashboard">
            <img src="/assets/images/icon/logo.png" alt="Cool Admin" />
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li class="<?= urlIs('/') ? 'active' : '' ?> has-sub">
                    <a class="js-arrow" href="/">
                        <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                    <!-- <ul class="list-unstyled navbar__sub-list js-sub-list">
                            <li>
                                <a href="index.html">Dashboard 1</a>
                            </li>
                            <li>
                                <a href="index2.html">Dashboard 2</a>
                            </li>
                            <li>
                                <a href="index3.html">Dashboard 3</a>
                            </li>
                            <li>
                                <a href="index4.html">Dashboard 4</a>
                            </li>
                        </ul> -->
                </li>

                <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') : ?>
                    <li>
                        <a href="/instructors">
                            <i class="<?= urlIs('/instructors') ? 'active' : '' ?> fas fa-chart-bar"></i>Instructor</a>
                    </li>
                    <li>
                        <a href="/admin/students" class="<?= urlIs('/admin/students') ? 'active' : '' ?>">
                            <i class="fas fa-table"></i>Students</a>
                    </li>
                    <li>
                        <a href="/admin/courses" class="<?= urlIs('/admin/courses') ? 'active' : '' ?>">
                            <i class="fas fa-table"></i>Courses</a>
                    </li>
                    
                    <li>
                        <a href="/requests" class="">
                            <i class="fas fa-table"></i>Instructor Requests</a>
                    </li>

                <?php else : ?>
                    <li>
                        <a href="instructor/enrolled/student">
                            <i class="far fa-check-square"></i>My Students</a>
                    </li>
                    <li>
                        <a href="/classes-index">
                            <i class="fas fa-calendar-alt"></i>Classes</a>
                    </li>

                    <li>
                        <a href="/courses">
                            <i class="fas fa-calendar-alt"></i>All Courses</a>
                    </li>


                <?php endif ?>
            </ul>
        </nav>
    </div>
</aside>