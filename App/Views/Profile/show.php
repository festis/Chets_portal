<?php $title = 'Profile'; ?>
<?php include 'App/Views/components/header.php'; ?>
        <h1>Profile</h1>
        
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd><?php echo $user->name; ?></dd>
            <dt>Email</dt>
            <dd><?php echo $user->email; ?></dd>
            <dt>Store number</dt>
            <dd><?php echo $user->storeNumber ?></dd>
        </dl>
        
        <a class="btn btn-default" href="/<?php echo \App\Config::SITE_NAME; ?>/profile/edit">Edit</a>
        
<?php include 'App/Views/components/footer.php'; ?>