<?php $title = 'Runboard'; ?>
<?php include 'App/Views/components/header.php'; ?>
<?php include 'runboard_nav.php'; ?>
        <?php if (isset($transID)) {
            echo '<h1>Edit this run</h1>';
        } else {
            echo '<h1>Add a new run</h1>';
        } ?>
        
        <?php include 'input_form.php'; ?>
<?php include 'App/Views/components/footer.php'; ?>