<?php $title = 'Home'; ?>
<?php include 'App/Views/components/header.php'; ?>
        <h1>Welcome to the Employee portal version 2.0!</h1>
        <?php if ($user = App\Auth::getUser()): ?>
            <div class="jumbotron">
                <h1>Hello, <?php echo $user->name; ?></h1>
                <p>
                    There has recently been a lot of re-organization of the company and as such people have been re-assigned to different stores. 
                    We currently have your store number as <?php echo $user->storeNumber; ?>.
                    If this is incorrect please click the profile link and update to your current store. Thanks~!
                </p>
            
            </div>
            <!-- 
	                
	        -->
            <div class="text-center">
            <h1>Variable contribution program</h1>
            <p>Numbers updated as of <u>January 12th</u></p>
            <p><h2>New year New goals</h2></p>
        </div>
            <div class="text-center"><h2>Overall Quarterly Progress</h2></div>
            <div class="form-inline">
            <span style="margin-left: 20%">January</span><span style="margin-left: 20%">February</span><span style="margin-left: 20%">March</span>
        </div>
            <div class="progress">                
                <div class="progress-bar progress-bar-striped active" role="progressbar"
                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="0" style="width:0%">
                    0%
                </div>
            </div>
        <hr />
        <div class="text-center"><h2>Progress for January</h2></div>
            <div class="progress">                
                <div class="progress-bar progress-bar-striped active" role="progressbar"
                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="0" style="width:0%">
                    0%
                </div>
            </div>
        <?php else: ?>
        <div style="width:75%; font-size:1.2em;">
        <p>In an effort to make the portal more user friendly and aesthetically pleasing we've redesigned it from the ground up. I think you'll like the improvements we've come up with.</p>
        <p>The majority of the changes are on the server side which most of you will be unaware of, other than it will run slightly faster, but I assure you this is a major overhaul to the inner-workings</p>
        <p>If you haven't done so yet you will need to self register to gain access. It only takes a couple minutes of your time and is relatively painless. The IT department will no longer have any access to your passwords, nor will we be able to change them, you can handle all that through the portal.</p>
        <p>Some of you may need an upgraded account to access certain features such as completing a lift inspection, or changing the lift inspector. If you believe you need one of these accounts please open an IT ticket <a href="http://www.chetsrentall.com/helpdesk">here.</a> after you've registered your account</p>
        <a href="/<?php echo \App\Config::SITE_NAME; ?>/signup/new">Sign Up</a> or
        <a href="/<?php echo \App\Config::SITE_NAME; ?>/login">Log in</a>
        </div>
        <?php endif; ?>
<?php include 'App/Views/components/footer.php'; ?>