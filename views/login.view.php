<?php require base_path('views/partials/head.php') ?>
<div class="page-content--bge5">
    <div class="container">
        <div class="login-wrap">
            <div class="login-content">
                <div class="login-logo">
                    <a href="#">
                        <img src="assets/images/icon/logo.png" alt="CoolAdmin">
                    </a>
                </div>
                <div class="login-form">
                    <form action="/authenticate" method="post">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input class="au-input au-input--full" type="email" name="email" value="<?= htmlspecialchars(old('email')) ?>">
                            <?php if (isset($errors['email'])) : ?>
                                <p class="text-danger text-xs mt-2"><?= htmlspecialchars($errors['email']) ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input class="au-input au-input--full" id="password" name="password" type="password" autocomplete="current-password">
                            <?php if (isset($errors['password'])) : ?>
                                <p class="text-danger text-xs mt-2"><?= htmlspecialchars($errors['password']) ?></p>
                            <?php endif; ?>
                        </div>
                        <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">Sign In</button>
                    </form>
                </div>
                <div class="register-link">
                    <p>
                        Don't you have an account?
                        <a href="/register">Sign Up Here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require base_path('views/partials/footer.php') ?>
