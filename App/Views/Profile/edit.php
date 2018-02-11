 <?php $title = 'Edit'; ?>
<?php include 'App/Views/components/header.php'; ?>
        <h1>Edit</h1>
        
        <?php if (!empty($user->errors)) : ?>
        <p>Errors:</p>
        <ul>
            <?php foreach ($user->errors as $error) : ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        
        <form method="POST" action="/<?php echo \App\Config::SITE_NAME; ?>/profile/update" id="formProfile"> 
            <div class="col-md-4">
                <div class="form-group">
                    <label for="inputName">Name</label>
                    <input id="inputName" name="name" placeholder="Name" value="<?php if(isset($user->name)){ echo $user->name;} ?>" required 
                           class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="inputEmail">Email address</label>
                    <input id="inputEmail" name="email" placeholder="Email Address" value="<?php if(isset($user->email)){ echo $user->email;} ?>" required type="email" 
                           class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="inputPassword">Password</label>
                    <input type="password" id="inputPassword" name="password" placeholder="Password" 
                        aria-describedby="helpBlock" 
                        class="form-control" />
                    <span id="helpBlock" class="help-block">Leave blank to keep your current password</span>
                </div>            
                <div class="col-md-5">
                    <label for="inputStoreNumber">Store Number</label> 
                    <div class="form-group">
                        <select class="form-control" id="storeNumber" name="storeNumber">
                        <?php foreach ($stores as $store): ?>                        
                        <option <?php if ($store['storeNumber'] == $user->storeNumber){echo 'selected';} ?>>
                            <?php echo $store['storeNumber']; ?>
                        </option>                       
                        <?php endforeach; ?>
                    </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
            
            <button type="submit" class="btn btn-default">Save</button>
            <a href="/<?php echo \App\Config::SITE_NAME; ?>/profile/show">Cancel</a>
            </div>
        </form>
<?php include 'App/Views/components/footer.php'; ?>