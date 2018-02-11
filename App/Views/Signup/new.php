<?php $title = 'Sign Up'; ?>
<?php include 'App/Views/components/header.php'; ?>
        <h1>Sign Up</h1>
        
        <?php if (!empty($user->errors)) : ?>
        <p>Errors:</p>
        <ul>
            <?php foreach ($user->errors as $error) : ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        
        <form method="POST" action="/<?php echo \App\Config::SITE_NAME; ?>/signup/create" id="formSignup">
            <div class="col-md-12">
                <div class=" col-md-3 form-group clearfix">
                    <label for="inputName">Name</label>
                    <input id="inputName" name="name" placeholder="Name" autofocus value="<?php if(isset($user->name)){ echo $user->name;} ?>" required 
                           class="form-control" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3 form-group">
                    <label for="inputEmail">Email address</label>
                    <input id="inputEmail" name="email" placeholder="Email Address" value="<?php if(isset($user->email)){ echo $user->email;} ?>" required type="email" 
                           class="form-control" />
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="col-md-3 form-group">
                    <label for="inputPassword">Password</label>
                    <input type="password" id="inputPassword" name="password" placeholder="Password" required 
                           class="form-control" />
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="col-md-3 form-group">
                    <label for="inputStoreNumber">Store Number</label>
                    <input id="inputStoreNumber" name="storeNumber" placeholder="Store Number" value="<?php if(isset($user->storeNumber)){ echo $user->storeNumber;} ?>" required 
                           class="form-control" />
                </div>
            </div>         
            <div class="col-md-12">
                <button type="submit" class="btn btn-success">Sign up</button>
            </div>
        </form>
<?php include 'App/Views/components/footer.php'; ?>