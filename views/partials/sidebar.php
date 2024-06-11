<aside class="menu-sidebar d-none d-lg-block">
        <div class="logo">
            <a href="#">
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
                        <a href="/students">
                            <i class="<?= urlIs('/students') ? 'active' : '' ?>fas fa-table"></i>Students</a>
                    </li>

                    <?php else : ?>
                    <li>
                        <a href="form.html">
                            <i class="far fa-check-square"></i>Forms</a>
                    </li>
                    <li>
                        <a href="/classes-index">
                            <i class="fas fa-calendar-alt"></i>Classes</a>
                    </li>
                   
                    <li class="has-sub">
                        <a class="js-arrow" href="#">
                            <i class="fas fa-copy"></i>Pages</a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                            <li>
                                <a href="login.html">Login</a>
                            </li>
                            <li>
                                <a href="register.html">Register</a>
                            </li>
                            <li>
                                <a href="forget-pass.html">Forget Password</a>
                            </li>
                        </ul>
                    </li>
                    <?php endif ?>
                </ul>
            </nav>
        </div>
    </aside>