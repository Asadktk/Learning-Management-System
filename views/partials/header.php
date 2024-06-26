<header class="header-desktop">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="header-wrap">
                <form class="form-header" action="" method="POST">
                    <input class="au-input au-input--xl" type="text" name="search" placeholder="Search for datas &amp; reports..." />
                    <button class="au-btn--submit" type="submit">
                        <i class="zmdi zmdi-search"></i>
                    </button>
                </form>
                <div class="header-button">
                    <div class="noti-wrap">


                        <!-- <div class="noti__item js-item-menu">
                            <a class="au-btn au-btn-icon au-btn--blue" href="/run-seeder">Run Seeder</a>


                        </div> -->
                    </div>
                    <div class="account-wrap">

                        <?php if ($_SESSION['user'] ?? false) : ?>
                            <div class="account-item clearfix js-item-menu">
                                <div class="image">
                                    <img src="/assets/images/icon/avatar-01.jpg" alt="John Doe" />
                                </div>
                                <div class="content">
                                    <a class="js-acc-btn" href="#"><?php echo htmlspecialchars($_SESSION['user']['name']); ?></a>
                                </div>
                                <div class="account-dropdown js-dropdown">
                                    <div class="info clearfix">
                                        <div class="image">
                                            <a href="#">
                                                <img src="/assets/images/icon/avatar-01.jpg" alt="John Doe" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h5 class="name">
                                                <a href="#"><?php echo htmlspecialchars($_SESSION['user']['name']); ?></a>
                                            </h5>
                                            <span class="email"><?php echo htmlspecialchars($_SESSION['user']['email']); ?></span>
                                        </div>
                                    </div>
                                    <div class="account-dropdown__body">
                                    <?php if ($_SESSION['user']['role'] === 'instructor') : ?>
                                        <div class="account-dropdown__item">
                                            <a href="/instructor/profile">
                                                <i class="zmdi zmdi-account"></i>Account</a>
                                        </div>
                                        <?php endif ?>
                                         
                                    <div class="account-dropdown__footer">
                                        <div class="margin-right">
                                            <form action="/logout" method="POST">

                                                <input type="hidden" name="_method" value="DELETE" />
                                                <i class="zmdi zmdi-money-box"></i> <button>Log Out</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else : ?>

                    </div>

                    <div class="account-wrap">
                        <a class="au-btn au-btn-icon au-btn--green au-btn--small" href="/login">Sign In</a>

                    </div>
                    <div class="account-wrap">
                        <a class="au-btn au-btn-icon au-btn--green au-btn--small" href="/register">Register</a>

                    </div>

                <?php endif ?>
                </div>

            </div>
        </div>
    </div>
</header>