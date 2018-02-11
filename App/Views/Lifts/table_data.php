    <?php if ($lift['active'] == '1'): ?>    
        <tr>                            
            <td>
                <?php if ($user->is_admin): ?>
                <a href="/<?php echo \App\Config::SITE_NAME ?>/modules/lifts/<?php echo $lift['id'] ?>/edit"><?php echo $lift['type']; ?></a>
                <?php else: ?>
                    <?php echo $lift['type']; ?>
                <?php endif; ?>
            </td>
            <td><?php echo $lift['category']; ?></td>
            <td><?php echo $lift['item']; ?></td>
            <td><?php echo $lift['make']; ?></td>
            <td><?php echo $lift['model']; ?></td>
            <td><?php echo $lift['serial']; ?></td>
            <td><?php echo $lift['purchased_date']; ?></td>
            <td><?php echo $lift['last_insp_date']; ?></td>                        

            <?php if ($user->is_admin): ?>
                <?php switch ($lift['inspector']) {
                    case 'Canton' :
                        echo '<td style = "background-color: #95bcf9;">';
                        break;
                    case 'Novi' :
                        echo '<td style = "background-color: #96f48d;">';
                        break;
                    case 'Rochester Hills' :
                        echo '<td style = "background-color: #ff4f4f;">';
                        break;
                    case 'Waterford' :
                        echo '<td style = "background-color: #be76fc;">';
                        break;                                    
                    default :
                        echo '<td>';
                        break;
                } ?>
                    <form action="/<?php echo \App\Config::SITE_NAME; ?>/modules/lifts/updateInspector" method="POST">
                        <input type="hidden" name="id" value="<?php echo $lift['id']; ?>" />
                        
                        <select name="inspector" onchange="this.form.submit()">
                            <?php
                                $options = array('Canton', 'Novi', 'Rochester Hills', 'Waterford', 'None');
                                foreach ($options as $store) {
                                    echo '<option';
                                    if ($lift['inspector'] == $store){
                                        echo ' selected';
                                    }                                                
                                    echo '>' . $store . '</option>';
                                }
                            ?>
                        </select>
                    </form>
                </td>
                <?php endif; ?>


        </tr>
    <?php endif; ?>    