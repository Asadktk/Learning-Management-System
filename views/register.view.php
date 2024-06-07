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
                    <form action="/register-store" method="post">
                        <div class="form-group">
                            <label>Username</label>
                            <input class="au-input au-input--full" type="text" name="name" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input class="au-input au-input--full" type="email" name="email" placeholder="Email" value="<?= htmlspecialchars(old('email')) ?>">
                            <?php if (isset($errors['email'])) : ?>
                                <p class="text-danger text-xs mt-2"><?= htmlspecialchars($errors['email']) ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input class="au-input au-input--full" type="password" name="password" placeholder="Password">
                            <?php if (isset($errors['password'])) : ?>
                                <p class="text-danger text-xs mt-2"><?= htmlspecialchars($errors['password']) ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <select name="role_id" id="role_id" class="form-control">
                                <!-- <option value="0">Please select</option> -->
                                <?php foreach ($roles as $role) : ?>
                                    <option value="<?= $role['id'] ?>"><?= $role['role'] ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                        <!-- <div class="login-checkbox">
                            <label>
                                <input type="checkbox" name="aggree">Agree the terms and policy
                            </label>
                        </div> -->
                        <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">register</button>

                    </form>


                </div>

            </div>
        </div>
    </div>
</div>
<?php require base_path('views/partials/footer.php') ?>