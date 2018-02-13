<?php


namespace App\Models;

use PDO;
use App\Mail;
use APP\Auth;

/**
 * User Model
 * 
 * PHP version 5.5
 */
class Purchasing_m extends \Core\Model
{
    /**
     * Send email to purchasing
     * 
     * @return boolean
     */

    public  static function sendEmail($data) { 
        // Get the User data to see if we add in the SOR info
        // First, Parse out who its going to based on request type
        $user = Auth::getUser();

        switch ($data['requestType']){
            case 'saleable':
            case 'supplies':
            // Live address
            $to = 'purchasing@chetsrentall.com';
            
            // Testing address
            //$to = 'jeremy.gransden@gmail.com';
            break;
        case 'parts':
                // Live addresses
        	$to = 'purchasing@chetsrentall.com';
        	$cc[] = 'cpiro@chetsrentall.com';
                
                //Testing addresses
            //$to = 'jgransden@chetsrentall.com';
        	//$cc[] = 'dgransden@chetsrentall.com';
        	break;
        default :
            // Live address
            $to = 'purchasing@chetsrentall.com';
            
            // Testing address
            //$to = 'jgransden@chetsrentall.com';
            // $cc[] = NULL;
        }
        
        // Now add the email addresses of the store
        // Get all stores from the database
        $allStores = Helpers::getStores();
        // parse the store from the data array
        $storeForm = ucfirst(preg_replace( "/[^a-z]/i", "", $data['fromStore']));
        foreach ($allStores as $store) {
            if ($store['storeName'] == $storeForm) {
                $cc[] = $store['storeEmail'];
                $storeAddress = $store['storeAddress'];
            }
        }        
        // Build the HTML version of the email
        $partCount = count($data['partNum']);
        if ($data['return'] == '1'){
            $msgHeader = '<h1 style="color:red;">THIS IS A RETURN</h1><br />';
        }
        else{
            $msgHeader = '';
        }
        $msgHeader .= '<b>Store: &emsp;</b>' . $storeForm . '<br />';
        $msgHeader .= '<b>Store address: &emsp;</b>' . 'Chet&#39;s Rent All - ' . $storeAddress . '<br />';
        $msgHeader .= '<b>Requestor: &emsp;</b>' . $data['requestor'] .'<br />';
        $msgHeader .= '<b>Work Order Number: &emsp;</b>' . $data['workOrder'] . '<br />';
        $msgHeader .= '<b>Cat-Item: &emsp;</b>' . $data['machineCat'] .'-'. $data['machineItem'] . '<br />';
        $msgHeader .= '<b>Item Description: &emsp;</b>' . $data['machineDesc'] . '<br />';
        $msgHeader .= '<b>Requested Vendor: &emsp;</b>' . $data['vendor'] . '<br />';
        $msgHeader .= '<b>Date Needed: &emsp;</b>' . $data['date'] . '<br />';
        $msgHeader .= '<b>Date Ordered: &emsp;</b>' . date(DATE_RFC2822) . '<br />';
        $msgHeader .= "<b>Request Type: &emsp;</b>" . $data['requestType'] . '<br />';
        if ($data['return'] == '1'){
            $msgHeader .= "<b>Original P.O.: &emsp;</b>" . $data['oldPO'] . '<br />';
            $msgHeader .= '<h1 style="color:red;">THIS IS A RETURN</h1><br />';
        }



        // added on 07-12-2017 for Suggested Order Report
        if ($user->is_storeManager and ($data['requestType'] == 'parts' or $data['requestType']== 'saleable')){
            if ($data['add_SOR'] == '1'){
                $msgHeader .= '<b>Add to Suggested Order Report: &emsp;</b>' . "Yes" . "\r\n";
            }
        }


        $msgFooter = '<b>Comments: </b><br />' . $data['comments'] . '<br />';
        
        $msg = '<table border="1"><tr><b><td>Part Number</td><td>Cat #</td><td>Item #</td><td>Description</td><td>Quantity</td><td>Unit Of Measure</td></b></tr>';
            for ($i = 0; $i<$partCount; $i++){
	$msg.= "<tr>";
	$msg.= "<td>". strtoupper($data['partNum'][$i]) .  "</td>";
	$msg.= "<td>". strtoupper($data['catNum'][$i]) .  "</td>";
	$msg.= "<td>". strtoupper($data['itemNum'][$i]) .  "</td>";
	$msg.= "<td>". strtoupper($data['desc'][$i]) .  "</td>";
	$msg.= "<td>". strtoupper($data['quantity'][$i]) . "</td>";
	$msg.= "<td>". strtoupper($data['unit'][$i]) .  "</td>";
	$msg.= "</tr>";
        }
        $msg.="</table>";
        
        // Build the text version of the email incase HTML is blocked
        $textHeader = "This message looks better if you enable HTML emails \r\n";
        if ($data['return'] == "1"){
            $textHeader .= "!!! THIS IS A RETURN !!! \r\n";
        }
        $textHeader .= "Store: " . $storeForm . "\r\n";
        $textHeader .= 'Store address: Chet\'s Rent All - ' . $storeAddress. "\r\n";
        $textHeader .= 'Requestor: ' . $data['requestor'] . "\r\n";
        $textHeader .= 'Work order number: ' . $data['workOrder'] . "\r\n";
        $textHeader .= 'Cat - Item: ' . $data['machineCat'] . '-' . $data['machineItem'] . "\r\n";
        $textHeader .= 'Item description: ' . $data['machineDesc'] . "\r\n";
        $textHeader .= 'Requested vendor: ' . $data['vendor'] . "\r\n";
        $textHeader .= 'Date ordered: ' . date(DATE_RFC2822) . "\r\n";
        $textHeader .= 'Date needed: ' . $data['date'] . "\r\n";
        $textHeader .= 'Request Type: ' . $data['requestType'] . "\r\n";
        if ($data['return'] == '1'){
            $textHeader .= "Original P.O.: " . $data['oldPO'] . "\r\n";
            $textHeader .= "!! THIS IS A RETURN !!! \r\n";
        }

        //Added on 07-12-2017 for the Suggested Order Report
        if ($user->is_storeManager and ($data['requestType'] == 'parts' or $data['requestType']== 'saleable')){
            if ($data['add_SOR'] == '1'){
                $textHeader .= 'Add to Suggested Order Report: ' . "Yes" . "\r\n";
            }
        }
        $textHeader .= "!!! THIS IS A RETURN !!! \r\n";


        $textFooter = 'Comments: ' . $data['comments'] . "\r\n";
        
        $textBody = "Part Number Cat # Item # Description Quantity Unit Of Measure \r\n";
        
        for ($i = 0; $i<$partCount; $i++){
            $textBody.= strtoupper($data['partNum'][$i]) .  ' ';
            $textBody.= strtoupper($data['catNum'][$i]) .  ' ';
            $textBody.= strtoupper($data['itemNum'][$i]) .  ' ';
            $textBody.= strtoupper($data['desc'][$i]) .  ' ';
            $textBody.= strtoupper($data['quantity'][$i]) . ' ';
            $textBody.= strtoupper($data['unit'][$i]) .  ' ';
        }
        if ($data['return'] == '1'){
            $subject = 'RETURN Request';
        }
        else {
            $subject = 'New Purchase Request';
        }
        $text = $textHeader . $textBody . $textFooter;
        $html = $msgHeader . $msg . $msgFooter;

        
        Mail::send($to, $subject, $text, $html, $cc); 
         
    }
    
    /**
     * Save the request to the database
     * 
     * @return void
     */
    public static function savePurchase($data) {
        // add in the user object
        $user = Auth::getUser();
        
        // First save the order data
        $sql = "INSERT INTO orders (
                            store, 
                            requestor, 
                            vendor, 
                            category, 
                            item_num, 
                            item_desc, 
                            type, 
                            date_required,
                            work_order, 
                            comments,
                            add_SOR,
                            itemReturn) 
                        VALUES (
                            :store, 
                            :requestor, 
                            :vendor, 
                            :category, 
                            :item_num, 
                            :item_desc, 
                            :type, 
                            :date_required, 
                            :work_order, 
                            :comments,
                            :add_SOR,
                            :itemReturn)";
        
        $db = static::getDB();
        $storeForm = ucfirst(preg_replace( "/[^a-z]/i", "", $data['fromStore']));
        
        $stmt = $db->prepare($sql);
            
        $stmt->bindValue(':store',      $storeForm, PDO::PARAM_INT);        
        $stmt->bindValue(':requestor',       $data['requestor'], PDO::PARAM_STR);
        $stmt->bindValue(':vendor',           $data['vendor'], PDO::PARAM_STR);
        $stmt->bindValue(':category',    $data['machineCat'], PDO::PARAM_INT);
        $stmt->bindValue(':item_num',     $data['machineItem'], PDO::PARAM_INT);
        $stmt->bindValue(':item_desc',        $data['machineDesc'], PDO::PARAM_STR);
        $stmt->bindValue(':type',        $data['requestType'], PDO::PARAM_STR);
        $stmt->bindValue(':date_required',     $data['date'], PDO::PARAM_STR);
        $stmt->bindValue(':work_order',     $data['workOrder'], PDO::PARAM_INT);
        $stmt->bindValue(':comments',          $data['comments'], PDO::PARAM_STR);
        if ($user->is_storeManager){
            $stmt->bindValue(':add_SOR',        $data['add_SOR'] );
        }
        else{
            $stmt->bindValue(':add_SOR', 0);
        }
        $stmt->bindValue(':itemReturn',     $data['return'] );
        $stmt->execute();
        
        // We will need the record number of the what we just inserted
        $orderNumber = $db->lastInsertId();
        $partCount = count($data['partNum']);
        
        // Now save the parts
        for ($i = 0; $i<$partCount; $i++){
            $partData = array(
                'part_num' => $data['partNum'][$i],
                'cat' => $data['catNum'][$i],
                'item' => $data['itemNum'][$i],
                'description' => $data['desc'][$i],
                'qty' => $data['quantity'][$i],
                'uom' => $data['unit'][$i],
                'orderNumber' => $orderNumber
            );
            static::saveParts($partData);
        }
        
    }
    
    /**
     * Save the parts
     * 
     * @return void
     */
    private static function saveParts($partData) {
        $sql = "INSERT INTO parts (
                            part_num, 
                            cat, 
                            item, 
                            description, 
                            qty, 
                            uom, 
                            order_num) 
                        VALUES (
                            :part_num, 
                            :cat, 
                            :item, 
                            :description, 
                            :qty, 
                            :uom, 
                            :order_num)";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
            
        $stmt->bindValue(':part_num',      $partData['part_num'], PDO::PARAM_INT);        
        $stmt->bindValue(':cat',       $partData['cat'], PDO::PARAM_INT);
        $stmt->bindValue(':item',           $partData['item'], PDO::PARAM_INT);
        $stmt->bindValue(':description',    $partData['description'], PDO::PARAM_STR);
        $stmt->bindValue(':qty',     $partData['qty'], PDO::PARAM_INT);
        $stmt->bindValue(':uom',        $partData['uom'], PDO::PARAM_STR);
        $stmt->bindValue(':order_num',        $partData['orderNumber'], PDO::PARAM_INT);
        
        $stmt->execute();
    }
}
