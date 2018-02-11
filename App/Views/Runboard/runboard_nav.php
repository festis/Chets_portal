<nav class="navbar navbar">
    <div class="container-fluid">
        <ul class="nav navbar-nav">
            <li><a href="/<?php echo \App\Config::SITE_NAME ?>/modules/runboard/index">Main page</a></li>
            <li><a href="/<?php echo \App\Config::SITE_NAME ?>/modules/runboard/allruns">All Runs</a></li>            
            <li><a href="/<?php echo \App\Config::SITE_NAME ?>/modules/runboard/onrent">On Rent</a></li>
            <li><a href="/<?php echo \App\Config::SITE_NAME ?>/modules/runboard/longterm">Long Term</a></li>
            <li><a href="/<?php echo \App\Config::SITE_NAME ?>/modules/runboard/repair">Repair</a></li>
            <li><a href="/<?php echo \App\Config::SITE_NAME ?>/modules/runboard/movement">Movement</a></li>
        </ul>
        
        <ul class="nav navbar-nav navbar-right"> 
            <li> <a href="/<?php echo \App\Config::SITE_NAME ?>/modules/runboard/addrun"><button class="btn btn-success" style="margin: -8px 0 -8px 0">Add run</button> </a></li>              
        </ul>
    </div>
</nav>