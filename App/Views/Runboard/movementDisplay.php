<?php $title = 'Runboard'; ?>
<?php include 'App/Views/components/header.php'; ?>
<?php include 'runboard_nav.php'; ?>
<?php if (isset($data[0])): ?>
<h1>All runs from store <?php echo $data[0]['fromStore']; ?> to store <?php echo $data[0]['toStore']; ?></h1>
<div class="table-responsive">
            <table class="table table-striped table-bordered tablesorter">
                <thead>
                    <?php include 'headers_with_type.php'; ?>
                </thead>
                
                <tbody>
                    <?php foreach ($data as $run): ?>
                        <?php include 'table_data_with_type.php'; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
<?php endif; ?>
<?php if (!isset($data[0])): ?>
<h1>We could not find any of those</h1>
<p><a href="/<?php echo \App\Config::SITE_NAME . '/modules/runboard/movement'; ?>"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back</a></p>
<?php endif ?>
<?php include 'App/Views/components/footer.php'; ?>