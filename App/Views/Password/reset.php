<?php $title = 'Reset Password'; ?>
<?php include 'App/Views/components/header.php'; ?>
        <h1>Reset your password</h1>
        
        <?php if (!empty($user->errors)) : ?>
        <p>Errors:</p>
        <ul>
            <?php foreach ($user->errors as $error) : ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        
        <form method="POST" action="/<?php echo \App\Config::SITE_NAME; ?>/password/reset-password" id="formPassword">            
            <input type="hidden" name="token" value="<?php echo $token; ?>" />
            <div class="col-md-3 form-group">
                <label for="inputPassword">Password</label>
                <input type="password" id="inputPassword" name="password" placeholder="Password" required 
                       class="form-control" />
            </div> 
            <div class="col-md-12">
                <button type="submit" class="btn btn-default">Reset password</button>
            </div>
        </form>
<?php include 'App/Views/components/footer.php'; ?>