<?php $title = 'Runboard'; ?>
<?php include 'App/Views/components/header.php'; ?>
<?php include 'runboard_nav.php'; ?>
<form action="/<?php echo \App\Config::SITE_NAME; ?>/modules/runboard/movementDisplay" method="POST">    
            <div class="col-md-3 form-group">
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
                
                <label for="toStore">To Store</label>
                <?php if (isset($toStore) ? $selected = $toStore : $selected = NULL); ?>                
                <select id="toStore" name="toStore" class="form-control">
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
            <div class="col-md-12 form-group">
                <button type="submit" class="btn btn-success ">Submit</button> | 
                <a href="/<?php echo \App\Config::SITE_NAME ?>/modules/runboard/index">Cancel</a>
            </div>            
            </form>
<?php include 'App/Views/components/footer.php'; ?>