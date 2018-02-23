<?php $title = 'Runboard'; ?>
<?php include 'App/Views/components/header.php'; ?>
<form action="/<?php echo \App\Config::SITE_NAME; ?>/modules/runboard/delete" method="POST">
<?php include 'runboard_nav.php'; ?>
        <?php if (!empty($rental)): ?>
        <h2><?php echo $username; ?>&#8217;s Rental Runs</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered tablesorter">
                <thead>
                    <?php include 'headers.php'; ?>
                </thead>
                
                <tbody>
                    <?php foreach ($rental as $run): ?>
                        <?php include 'table_data.php'; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($interCompany)): ?>
        <h2><?php echo $username; ?>&#8217;s Inter Company Runs</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered tablesorter">
                <thead>
                    <?php include 'headers.php'; ?>
                </thead>
                
                <tbody>
                    <?php foreach ($interCompany as $run): ?>                    
                        <?php include 'table_data.php'; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($parts)): ?>
        <h2><?php echo $username; ?>&#8217;s Parts Runs</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered tablesorter">
                <thead>
                    <?php include 'headers.php'; ?>
                </thead>
                
                <tbody>
                    <?php foreach ($parts as $run): ?>                    
                        <?php include 'table_data.php'; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($other)): ?>
        <h2><?php echo $username; ?>&#8217;s Other Runs</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered tablesorter">
                <thead>
                    <?php include 'headers.php'; ?>
                </thead>
                
                <tbody>
                    <?php foreach ($other as $run): ?>                    
                        <?php include 'table_data.php'; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        
        <?php if (!empty($notOwn)): ?>
        <h2><?php echo $username; ?>&#8217;s Runs either to, or from you entered by another store</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered tablesorter">
                <thead>
                    <?php include 'headers.php'; ?>
                </thead>
                
                <tbody>
                    <?php foreach ($notOwn as $run): ?>                    
                        <?php include 'table_data.php'; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
</form>
        
<?php include 'App/Views/components/footer.php'; ?>
