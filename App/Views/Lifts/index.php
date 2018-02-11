<?php $title = 'Lifts'; ?>
<?php include 'App/Views/components/header.php'; ?>
<?php include 'lifts_nav.php'; ?>
<h1><?php echo $pageName; ?></h1>
    <?php if (!empty($lifts)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered tablesorter">
                <thead>
                    <?php include 'headers.php'; ?>
                </thead>
                
                <tbody>
                    <?php foreach ($lifts as $lift): ?>
                        <?php include 'table_data.php'; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
<?php else : ?>
<h2>We could not find any of those.</h2>
<?php endif; ?>
<?php include 'App/Views/components/footer.php'; ?>
