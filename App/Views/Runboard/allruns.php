<?php $title = 'Runboard'; ?>
<?php include 'App/Views/components/header.php'; ?>
<?php include 'runboard_nav.php'; ?>
        <?php if (!empty($rental)): ?>
        <h2>All Rental Runs</h2>
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
        <h2>All Inter Company Runs</h2>
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
        <h2>All Parts Runs</h2>
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
        <h2>All Other Runs</h2>
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
        
<?php include 'App/Views/components/footer.php'; ?>