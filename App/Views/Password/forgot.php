<?php $title = 'Forgot'; ?>
<?php include 'App/Views/components/header.php'; ?>
        <h1>Request a password reset</h1>
        <form action="/<?php echo \App\Config::SITE_NAME; ?>/password/request-reset" method="POST">
            <div class="col-md-3 form-group">
                <label for="inputEmail">Email address</label>
                <input type="email" id="inputEmail" name="email" placeholder="Email address" autofocus value="<?php if(isset($email)){ echo $email;} ?>"
                       class="form-control" />
            </div>           
            
            <div class="col-md-12">
                <button type="submit" class="btn btn-default">Send request</button>
            </div>
        </form>
<?php include 'App/Views/components/footer.php'; ?>