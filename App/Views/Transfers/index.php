<?php $title='Transfers'; ?>
<?php include 'App/Views/components/header.php'; ?>
<?php $user = App\Auth::getuser() ?>
<h1>Parts and Salable Transfers</h1>
<p>Please use this form for requesting transfers from other stores</p>
    <form action="/<?php echo \App\Config::SITE_NAME; ?>/modules/transfers/create" method="POST">
        <div class="col-md-4 form-group">
            <label for="fromStore">Store Items Are Needed From</label>
            <?php if (isset($fromStore) ? $selected = $fromStore : $selected = Null); ?>
            <select id="fromStore" name="fromStore" class="form-control">
                <?php if ($selected == Null): ?>
                    <?php foreach ($stores as $store): ?>
                        <option><?php echo $store['storeNumber'] . ' - ' . $store['storeName']; ?> </option>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if ($selected != NULL): ?>
                        <?php foreach ($stores as $store): ?>
                            <?php if ($selected == $store['storeNumber']): ?>
                            <option selected><?php echo $store['storeNumber'] . ' - ' . $store['storeName']; ?></option>
                            <?php endif; ?>
                            
                            <?php if ($selected != $store['storeNumber']): ?>
                            <option><?php echo $store['storeNumber'] . ' - ' . $store['storeName']; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="col-md-12">
            <label for="transferReason">Reason For Transfer</label>
            <textarea class="form-control" style="margin-bottom: 5px;" name="transferReason" rows="4" placeholder="Please put in the reason for the transfer."></textarea>
        </div>
        <div class="col-md-12 table-responsive">
            <table class="table table-bordered" id="mytable">
                <tr>
                    <th>Cat #</th>
                    <th>Itm #</th>
                    <th>Part #</th>
                    <th>Description</th>
                    <th>Qty</th>
                </tr>
                <tbody>
                    <tr>
                        <td><input class="form-control" type="text" name="catNum[]" required /></td>
                        <td><input class="form-control" type="text" name="itemNum[]" required /></td>
                        <td><input class="form-control" type="text" name="partNum[]" required /></td>
                        <td><input class="form-control" type="text" name="description[]"></td>
                        <td><input class="form-control" type="text" name="qty[]" /></td>
                        <td><button class="btn btn-danger" id="deleteButton">Remove</td>
                    </tr>
                    <button style="margin-bottom: 4px;" class="btn btn-info" id="add">Add a Part</button>
                </tbody>
            </table>
        </div>
        <div class="col-md-12" style="margin-bottom: 10px;">
            <input type="submit" value="Submit" name="submit" id="btn-parts" class="btn btn-success" />
        </div>
    </form>
<?php include 'App/Views/components/footer.php'; ?>