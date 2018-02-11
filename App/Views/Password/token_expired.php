<?php $title = 'Forgot password'; ?>
<?php include 'App/Views/components/header.php'; ?>
        <h1>Request Password Reset</h1>
        <p>
            The password reset link is invalid or has expired, Please click <a href="/<?php echo \App\Config::SITE_NAME; ?>/password/forgot">here</a> to request another.
        </p>
<?php include 'App/Views/components/footer.php'; ?>