<?php $title = 'Lifts'; ?>
<?php include 'App/Views/components/header.php'; ?>
<?php include 'lifts_nav.php'; ?>
<h1>Update the database</h1>
<p>fill out this form to complete a lift inspection</p>
<h4>You are editing category: <b><?php echo $record[0]['category'] . '</b> - item: <b>' . $record[0]['item']; ?></b></h4>
<form action="/<?php echo \App\Config::SITE_NAME; ?>/modules/lifts/update" method="POST">
        <div class="col-md-4">
            <div class="col-md-12 form-group">
                <div class="input-group date datepicker" data-provide="datepicker">
                    <input type="hidden" name="id" value="<?php echo$record[0]['id'] ?>" />
                    <input type="hidden" name="inspectedBy" value="<?php echo $record[0]['inspector']; ?>" />
                <input type="date" class="form-control" name="date" id="date" required />
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </div>
                </div>
                <br />                
                <input type="text" id="technition" name="technition" placeholder="Name of Technition" 
                   autofocus value="<?php if(isset($technition)){ echo $technition; } ?>"
                   class="form-control" required />
                <br />
            </div>
        </div>
            <div class="col-md-12">                
                <legend>Comments</legend>
                <div class="col-md-6">
                    <textarea class="form-control" style="margin-bottom: 5px;" name="comments" rows="4" placeholder="Add any comments here"></textarea>
                </div>                
                <div class="col-md-12">
                    <input type="submit" value="Submit" name="submit" id="btn-parts" class="btn btn-success" />
                </div>
            </div>
        </form>
        
<?php include 'App/Views/components/footer.php'; ?>