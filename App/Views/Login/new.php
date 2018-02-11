<?php $title = 'Login'; ?>
<?php include 'App/Views/components/header.php'; ?>
        <h1>Log in</h1>
        <form action="/<?php echo \App\Config::SITE_NAME; ?>/login/create" method="POST">
            <div class="col-md-3 form-group">
                <label for="inputEmail">Email address</label>
                <input type="email" id="inputEmail" name="email" placeholder="Email address" autofocus value="<?php if(isset($email)){ echo $email;} ?>"
                       class="form-control" />
            </div>
            <div class="col-md-3 form-group">
                <label for="inputPassword">Password</label>
                <input type="password" id="inputPassword" name="password" placeholder="Password" 
                       class="form-control" />
            </div>
            <div class="col-md-12 checkbox">
                <label>
                    <input type="checkbox" name="remember_me" <?php if (isset($remember_me)):?> checked="checked" <?php endif;?>/> Remember me
                </label>
            </div>
            <div class="col-md-12">
            <button type="submit" class="btn btn-default">Log In</button>
            <a href="/<?php echo \App\Config::SITE_NAME; ?>/password/forgot">Forgot Password?</a>
            </div>
        </form>
<?php include 'App/Views/components/footer.php'; ?>