        <form action="/<?php echo \App\Config::SITE_NAME; ?>/modules/runboard/create" method="POST">
            
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
                
                <label for="Runtype">Run Type</label>
                <?php if (isset($runType) ? $selected = $runType : $selected = NULL); ?>                
                <select id="runType" name="runType" class="form-control">                    
                    <?php if ($selected == NULL): ?>
                        <?php foreach ($types as $type): ?>
                            <option><?php echo $type['type']; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                            
                    <?php if ($selected != NULL): ?>
                        <?php foreach ($types as $type): ?>
                            <?php if ($selected == $type['type']): ?>
                            <option selected><?php echo $type['type']; ?></option>
                            <?php endif; ?>
                            
                            <?php if ($selected != $type['type']): ?>
                            <option><?php echo $type['type'] ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <br />
                
                <label for="itemStatus">Item Status</label>
                <?php if (isset($itemStatus) ? $selected = $itemStatus : $selected = NULL); ?>                
                <select id="itemStatus" name="itemStatus" class="form-control">                    
                    <?php if ($selected == NULL): ?>
                        <?php foreach ($statuses as $status): ?>
                            <option><?php echo $status['itemStatus']; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                            
                    <?php if ($selected != NULL): ?>
                        <?php foreach ($statuses as $status): ?>
                            <?php if ($selected == $status['itemStatus']): ?>
                            <option selected><?php echo $status['itemStatus']; ?></option>
                            <?php endif; ?>
                            
                            <?php if ($selected != $status['itemStatus']): ?>
                            <option><?php echo $status['itemStatus'] ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <br />               
                
            </div>
            <div class="col-md-3 form-group">
                <input type="text" id="category" name="category" placeholder="Category" 
                   autofocus value="<?php if(isset($category)){ echo $category;} ?>"
                   class="form-control"
                />
                <br />
                
                <input type="text" id="item" name="item" placeholder="Item" 
                   autofocus value="<?php if(isset($item)){ echo $item;} ?>"
                   class="form-control"
                />
                <br />
                <input type="text" id="description" name="description" placeholder="Description" 
                       autofocus value="<?php if(isset($description)){ echo $description;} ?>"
                       class="form-control" required="required"
                />
                <br /> 
                
                <input type="text" id="dateNeeded" name="dateNeeded" placeholder="Date Needed" 
                       autofocus value="<?php if(isset($dateNeeded)){ echo $dateNeeded;} ?>"
                       class="form-control" required="required"
                />
                <br />
                
                <input type="text" id="timeNeeded" name="timeNeeded" placeholder="Time Needed" 
                       autofocus value="<?php if(isset($timeNeeded)){ echo $timeNeeded;} ?>"
                       class="form-control"
                /> 
                <br />
                

                <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Notes"><?php if(isset($notes)){ echo $notes;} ?></textarea>
                <br />
                
                <input type="hidden" name="update" value="<?php echo $update ?>" />
                <input type="hidden" name="transID" value="<?php echo $transID ?>" />
                <input type="hidden" name="exists" value="<?php echo $exists ?>" />
            </div>
            <div class="col-md-12 form-group">
                <button type="submit" class="btn btn-success ">Submit</button> | 
                <a href="/<?php echo \App\Config::SITE_NAME ?>/modules/runboard/index">Cancel</a>
            </div>
            
            </form>