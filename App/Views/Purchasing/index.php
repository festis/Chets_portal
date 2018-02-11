<?php $title = 'Purchasing'; ?>
<?php include 'App/Views/components/header.php'; ?>
<?php $user = App\Auth::getUser() ?>
<h1>Purchasing</h1>
        <form action="/<?php echo \App\Config::SITE_NAME; ?>/modules/purchasing/create" method="POST">            
            <div class="col-md-4 form-group">
                <label for="fromStore">From Store</label>
                <?php if (isset($fromStore) ? $selected = $fromStore : $selected = NULL); ?>                
                <select id="fromStore" name="fromStore" class="form-control">
                    <?php if ($selected == NULL): ?>
                        <?php foreach ($stores as $store): ?>
                            <option><?php echo $store['storeNumber'] . ' - ' . $store['storeName']; ?></option>
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
                <br />
                <input type="text" id="requestor" name="requestor" placeholder="Requestor" 
                   autofocus value="<?php if(isset($requestor)){ echo $requestor; } ?>"
                   class="form-control" required />
                <br />
                
                <input type="text" id="vendor" name="vendor" placeholder="Suggested vendor" 
                   autofocus value="<?php if(isset($vendor)){ echo $vendor; } ?>"
                   class="form-control" required />
                <br />

                <div class="input-group date datepicker" data-provide="datepicker">
                    <input type="date" class="form-control" name="date" id="date" required />
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </div>
                </div>
                <br /> 
                
                <div class="col-md-5 form-group">
                    <div class="radio">
                        <label><input type="radio" name="requestType" id="parts" value="parts" checked>Parts</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="requestType" id="saleable" value="saleable">Saleable</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="requestType" id="rental" value="rental">Rental</label>
                    </div>
                </div>
                <div class="col-md-7 form-group">
                    <div class="radio">
                        <label><input type="radio" name="requestType" id="supplies" value="supplies">Supplies</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="requestType" id="customer_quote" value="customer_quote">Customer Quote</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="requestType" id="customer_parts" value="customer_parts">Customer Parts</label>
                    </div>
                </div>
            </div>
            <div class="col-md-4 form-group">
                <label for="machineInfo">Equipment Information</label>
                <input type="text" id="workOrder" name="workOrder" placeholder="Work Order Number" 
                   autofocus value="<?php if(isset($workOrder)){ echo $workOrder; } ?>"
                   class="form-control" required />
                <br />
                
                <input type="text" id="machineCat" name="machineCat" placeholder="Equipment Category Number" 
                   autofocus value="<?php if(isset($machineCat)){ echo $machineCat; } ?>"
                   class="form-control" required />
                <br />
                
                <input type="text" id="machineItem" name="machineItem" placeholder="Equipment Item Number" 
                   autofocus value="<?php if(isset($machineItem)){ echo $machineItem; } ?>"
                   class="form-control" required />
                <br /> 
                
                <input type="text" id="machineDesc" name="machineDesc" placeholder="Equipment Description" 
                   autofocus value="<?php if(isset($machineDesc)){ echo $machineDesc; } ?>"
                   class="form-control" required />
                <br />
                <input type="hidden" name="add_SOR" value="0" >
                <?php if ($user->is_storeManager){
                echo '<input type="checkbox" id="add_SOR" name="add_SOR" value="1">   Add To the Suggested Order Report?<br />';
                }
                ?>
            </div>
            <hr class="col-md-12 divider" style="margin-left: -15px" />
            <div class="col-md-12 table-responsive">
                <table class="table table-bordered" id="mytable">
                    <tr>
                        <th>Part Number</th>
                        <th>Cat #</th>
                        <th>Item #</th>
                        <th>Description</th>
                        <th>Qty  </th>
                        <th>UoM</th>
                        <th></th>
                    </tr>
                    <tbody>
                    <tr>
                        <td><input class="form-control" type="text" name="partNum[]" required /></td>
                        <td><input class="form-control" type="text" name="catNum[]" required /></td>
                        <td><input class="form-control" type="text" name="itemNum[]" required /></td>
                        <td><input class="form-control" type="text" name="desc[]" required /></td>
                        <td><input class="form-control" type="text" name="quantity[]" required /></td>
                        <td>
                            <select class="form-control" style="min-width: 80px;" name="unit[]">
                                <option value = "each">Each</option>
                                <option value = "box">Box</option>
                                <option value = "lbs">LBS</option>
                            </select>
                        </td>
                        <td><button class="btn btn-danger" id="deleteButton">Remove</td>
                    </tr>
            
                    <button style="margin-bottom: 4px;" class="btn btn-info" id="add">Add a Part</button>
                    
                    </tbody>
                </table>
                <legend>Comments or Special Requests</legend>
                <div class="col-md-6">
                    <textarea class="form-control" style="margin-bottom: 5px;" name="comments" rows="4" placeholder="Add any comments or requests here"></textarea>
                </div>                
                <div class="col-md-12" style="margin-bottom: 10px;">
                    <input type="submit" value="Submit" name="submit" id="btn-parts" class="btn btn-success" />
                </div>
            </div>
        </form>
<?php include 'App/Views/components/footer.php'; ?>