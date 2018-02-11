<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php if (isset($title)){echo $title;} ?></title>
        <!-- Latest compiled and minified CSS -->        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />        
        <link rel="stylesheet" href="<?php echo HTTP; ?>/css/style.css" /> 
    </head>
    <body background="<?php echo HTTP; ?>/images/chets_portal_bg.jpg">
        <div class="container" style="background-color: white; min-height: 750px; padding-bottom:5px; box-shadow: 1px 1px 1px 5px #ccc; background-image: url('<?php echo HTTP; ?>/images/grey-texture.jpg'); ">
            <?php 
            foreach (App\Flash::getMessages() as $message ): ?>
        <div class="alert alert-<?php echo $message['type']; ?>">
            <?php echo $message['body']; ?>
        </div>
            <?php endforeach; ?>
            <nav class="navbar navbar" style="margin-bottom: 1px;">
                <?php $config = new \App\Config() ?>
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="/<?php echo \App\Config::SITE_NAME ?>/"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home</a></li>
                            <li><a href="https://time.paycor.com/kiosk/93916"  target="_blank"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> Paycor</a></li>
                            <?php if (App\Auth::getUser()): ?>
                                <?php foreach ($config->getModules() as $module): ?>
                                    <?php $module = lcfirst($module); ?>                        
                                    <li><a href="/<?php echo \App\Config::SITE_NAME . '/modules/' . $module . '/index'; ?>"><?php echo ucfirst($module); ?></a></li>
                                <?php endforeach; ?>

                                <?php if ($config->getNav_links()): ?>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">More Links <span class="caret"></span></a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                            <?php foreach ($config->getNav_links() as $nav => $url): ?>
                                                <?php $nav = ucfirst($nav); ?>
                                                    <li><a href="<?php echo $url; ?>" target="_blank"><?php echo $nav; ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                                    
                            <?php endif; ?>    
                        </ul>
                        <ul class="nav navbar-nav navbar-right">                        
                            <?php if (App\Auth::getUser()): ?>
                                <li><a href="/<?php echo \App\Config::SITE_NAME ?>/profile/show"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Profile</a></li>
                                <li><a href="/<?php echo \App\Config::SITE_NAME ?>/logout"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Log Out</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
        </nav>