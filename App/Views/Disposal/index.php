<?php $title ='Disposal'; ?>
<?php include 'App/Views/components/header.php'; ?>
<?php $user = App\Auth::getUser() ?>
<h1>Equipment Disposal</h1>
<p>Please use this form to submit for an equipment disposal</p>
        <form action="/<?php echo \App\Config::SITE_NAME; ?>/modules/disposal/create" method="POST">
            <div class="col-md-4 form-group">
                <div class="input-group date datepicker" data-provide="datepicker">
                    <input type="date" class="form-control" name="date" id="date" required/>
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </div>
                </div>
                <br />
            </div>
            <legend>Please add details about the disposal</legend>
            <div class="col-md-12">
                <textarea class="form-control" style="margin-bottom: 5px;" name="disposal_comments" rows="4" placeholder="Detail the reason for disposal"></textarea>
            </div>
            <br />
            <div class="col-md-12"></div>
            <legend>Info Needed If Stolen</legend>
            <div class="col-md-4 form-group">
                <label for="policeInfo">Police Info:</label>
                <input type="text" id="policeDepartment" name="policeDepartment" placeholder="Police Department" class="form-control" />
                <br />
                <div class="input-group date datepicker" data-provide="datepicker">
                    <input type="date" class="form-control" name="policeDate" id="policeDate" />
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </div> 
                </div>
                <br />
                <input type="text" id="reportNum" name="reportNum" placeholder="Report Number" class="form-control" />
            </div>
            <div class="col-md-4 form-group">
                <label for="nerReport">Reported to NER:</label>
                <input type="text" id="nerReportBy" name="nerReportBy" placeholder="Reported By" class="form-control" />
                <br />
                <div class="input-group date datepicker" data-provide="datepicker">
                    <input type="date" class="form-control" name="nerDate" id="nerDate" />
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 form-group">
                <label for="mfgReport">Reported Serial to Manufacturer:</label>
                <input type="text" id="mfgReportBy" name="mfgReportBy" placeholder="Reported By" class="form-control" />
                <br />
                <div class="input-group date datepicker" data-provide="datepicker">
                    <input type="date" class="form-control" name="mfgDate" id="mfgDate" />
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </div>
                </div>
            </div>
            <hr class="col-md-12 divider" style="margin-left: -15px" />
            <div class="col-md-12 table-responsive">
                <table class="table table-bordered" id="mytable">
                    <tr>
                        <th>Cat #</th>
                        <th>Item #</th>
                        <th>Serial #</th>
                        <th>MFG</th>
                        <th>Qty</th>
                        <th>Junked/Mysterious Disappearance</th>
                    </tr>
                    <tbody>
                        <tr>
                            <td><input class="form-control" type="text" name="catNum[]" required /></td>
                            <td><input class="form-control" type="text" name="itmNum[]" required /></td>
                            <td><input class="form-control" type="text" name="serialNum[]" required /></td>
                            <td><input class="form-control" type="text" name="mfg[]" required /></td>
                            <td><input class="form-control" type="text" name="quantity[]" required /> </td>
                            <td>
                                <select class="form-control" style="min-width: 80px;" name="disposalCode[]">
                                    <option value = "Scrapped">Scrapped</option>
                                    <option value = "Disappearance">Mysterious Disappearance</option>
                                </select>
                            </td>
                            <td><button class="btn-btn-danger" id="deleteButton">Remove</td>
                        </tr>
                        <button style="margin-bottom: 4px;" class="btn btn-info" id="add">Add an Item</button>
                    </tbody>
                </table>
                <div class="col-md-12" style="margin-bottom: 10px;">
                    <input type="submit" value="Submit" name="submit" id="btn-parts" class="btn btn-success" />
                </div>
            </div>
        </form>
<?php include 'App/Views/components/footer.php' ?>