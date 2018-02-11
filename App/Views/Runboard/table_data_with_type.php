                        <tr>
                            <td><a href="/<?php echo \App\Config::SITE_NAME ?>/modules/runboard/<?php echo $run['transID'] ?>/edit"><?php echo $run['fromStore']; ?></a></td>
                            <td><a href="/<?php echo \App\Config::SITE_NAME ?>/modules/runboard/<?php echo $run['transID'] ?>/edit"><?php echo $run['toStore']; ?></a></td>
                            <td><a href="/<?php echo \App\Config::SITE_NAME ?>/modules/runboard/<?php echo $run['transID'] ?>/edit"><?php echo $run['category']; ?></a></td>
                            <td><a href="/<?php echo \App\Config::SITE_NAME ?>/modules/runboard/<?php echo $run['transID'] ?>/edit"><?php echo $run['item']; ?></a></td>
                            <td><a href="/<?php echo \App\Config::SITE_NAME ?>/modules/runboard/<?php echo $run['transID'] ?>/edit"><?php echo $run['description']; ?></a></td>
                            <td><a href="/<?php echo \App\Config::SITE_NAME ?>/modules/runboard/<?php echo $run['transID'] ?>/edit"><?php echo $run['movementType']; ?></a></td>
                            <td><a href="/<?php echo \App\Config::SITE_NAME ?>/modules/runboard/<?php echo $run['transID'] ?>/edit"><?php echo $run['dateNeeded']; ?></a></td>
                            <td><a href="/<?php echo \App\Config::SITE_NAME ?>/modules/runboard/<?php echo $run['transID'] ?>/edit"><?php echo $run['timeNeeded']; ?></a></td>
                            <td><a href="/<?php echo \App\Config::SITE_NAME ?>/modules/runboard/<?php echo $run['transID'] ?>/edit"><?php echo $run['itemStatus']; ?></a></td>
                            <td><a href="/<?php echo \App\Config::SITE_NAME ?>/modules/runboard/<?php echo $run['transID'] ?>/edit"><?php echo $run['notes']; ?></a></td>
                            <td>
                                <form action="/<?php echo \App\Config::SITE_NAME; ?>/modules/runboard/delete" method="POST" onclick="return confirm('Are you sure?');"><input type="hidden" name="trans" value="<?php echo $run['transID'] ?>"><button type="submit" class="btn btn-danger btn-sm" id="delete">Delete</button></form>
                            </td>
                        </tr>