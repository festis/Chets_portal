<?php $title = 'Runboard'; ?>
<?php include 'App/Views/components/header.php'; ?>
<?php include 'runboard_nav.php'; ?>
        <?php if (!empty($data)): ?>
        <h2>All Runs with the <?php echo $data[0]['itemStatus'] ?> status</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered tablesorter">
                <thead>
                    <?php include 'headers.php'; ?>
                </thead>
                
                <tbody>
                    <?php foreach ($data as $run): ?>
                        <?php include 'table_data.php'; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        <?php if (empty($data)): ?>
        <h1>We were unable to find any of those.</h1>
        <?php endif; ?>
<?php include 'App/Views/components/footer.php'; ?>