<?php

// Transfer form Model. Mostly a copy of the purchasing App

namespace App\Models;

use PDO;
use App\Mail;
use APP\Auth;

class Transfers_m extends \Core\Model
{


    /** 
    *   Set up the email 1st.
    *   TODO:
    *   pull email data from a database field
    */
    public static function sendEmail($data) {
    
    $user = Auth::getUser();
    $userName = $user->name;
    $reqStroreNum = $user->storeNumber;
    $userID = $user->id;

    // Send A copy of the request to the person putting in the request.
    $cc[] = $user->email;

    // getting store email addresses
    $allStores = Helpers::getStores();
    $storeForm = ucfirst(preg_replace( "/[^a-z]/i", "", $data['fromStore']));
    foreach ($allStores as $store) {
        // store sending parts/items
        // change this to $to in production
        if ($store['storeName'] == $storeForm){
            $storeFromEmail = $store['storeEmail'];
            $to = $storeFromEmail;
        } 
        if ($store['storeNumber'] == $user->storeNumber){
            //uncomment for Live
            $reqStoreName = $store['storeName'];
            $cc[] = ($store['storeEmail']);

        }
    }

    
    //var_dump($userName);
    //var_dump($reqStroreNum);
    //var_dump($data['fromStore']);
    //var_dump($storeForm);
    //var_dump($storeFromEmail);
    //var_dump($cc);
    $partCount = count($data['catNum']);
    $msgHeader = '<b>Requestor: &emsp;</b>' . $userName . '<br />';
    $msgHeader .= '<b>Requesting Store: &emsp;</b>' . $reqStoreName . '<br />';
    $msgHeader .= '<b>Requested Parts/Items Coming From: &emsp;</b>' . $storeForm . '<br />';

    $msg = '<table border="1"><tr><b><td>Cat #</td><td>Item #</td><td>Part #</td><td>Description</td><td>Qty</td></b></tr>';
    for ($i = 0; $i<$partCount; $i++){
        $msg.="<tr>";
        $msg.="<td>". $data['catNum'][$i] . "</td>";
        $msg.="<td>". $data['itemNum'][$i] . "</td>";
        $msg.="<td>". $data['partNum'][$i] . "</td>";
        $msg.="<td>". $data['description'][$i] . "</td>";
        $msg.="<td>". $data['qty'][$i] . "</td>";
        $msg.="</tr>";
    }
    $msg.="</table>";

    $msgFooter = '<b>Reason For Transfer: </b> <br />' . $data['transferReason'] . '<br />';

    $textHeader = "Requestor: " . $userName . "\r\n";
    $textHeader .= "Requesting Store: " . $reqStoreName . "\r\n"; 
    $textHeader .= "Requested Parts/Items Coming From: " . $storeForm . "\r\n";

    $textBody = "Cat # Item # Part # Description Qty \r\n";
    for ($i = 0; $i<$partCount; $i++){
        $textBody.= $data['catNum'][$i] . ' ';
        $textBody.= $data['itemNum'][$i] . ' ';
        $textBody.= $data['partNum'][$i] . ' ';
        $textBody.= $data['description'][$i] . ' ';
        $textBody.= $data['qty'][$i] . ' ';
    }

    $textFooter = 'Reason For Transfer: \r\n' . $data['transferReason'] . "\r\n";

    $subject = 'New Transfer Request';
    $text = $textHeader . $textBody . $textFooter;
    $html = $msgHeader . $msg . $msgFooter;

    Mail::send($to, $subject, $text, $html, $cc);
    
    // remove after saveDisposal() is written

    }
    /**
    * Save the Data to the database
    *
    * @return void
    */
    public static function saveTransfers($data){

    // Create some constants for the sql inserts
        $user = Auth::getUser();
        // Save order Header
        $reqStoreNum = $user->storeNumber;
        $userID = $user->id;
        $storeForm = ucfirst(preg_replace( "/[^a-z]/i", "", $data['fromStore']));
        $allStores = Helpers::getStores();
        foreach ($allStores as $store){
            if ($store['storeName'] == $storeForm){
                $fromStoreNum = $store['storeNumber'];
            }
        }

        $headerData = array('fromStore' =>$fromStoreNum,
                            'toStore' => $reqStoreNum,
                            'storeID' => $reqStoreNum,
                            'transferReason' => $data['transferReason'] );        

        $sql = "INSERT INTO transfer_head (
                        requestingStore,
                        requestorId,
                        requestedFrom,
                        transferReason)
                  Values (
                        :reqStore,
                        :userRequesting,
                        :requestedFrom,
                        :transferReason)";
            
        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':reqStore', $reqStoreNum);
        $stmt->bindValue(':userRequesting', $userID);
        $stmt->bindValue(':requestedFrom', $fromStoreNum);
        $stmt->bindValue(':transferReason', $data['transferReason']);


        $stmt->execute();
        // exit();
        // Get id of last insert
        $insertId = $db->lastinsertId();
        // get total number of parts for the order

        $partCount = count($data['catNum']);
        // save each item on the request to table
        for ($i = 0; $i<$partCount; $i++){
            $itemData = array(
                'cat_num' => $data['catNum'][$i],
                'itm_num' => $data['itemNum'][$i],
                'part_num' => $data['partNum'][$i],
                'description' => $data['description'][$i],
                'qty' =>     $data['qty'][$i],
                'orderID' => $insertId
            );
            static::saveParts($itemData);
            static::addRunboard($headerData, $itemData);
        }
    }

    /**
    * Save the Parts
    *
    * @return void
    */
    private static function saveParts($itemData){
        // make sure column names are correct
        $sql = "INSERT INTO transfer_detail(
                            catNum,
                            itemNum,
                            partNum,
                            description,
                            qty,
                            transId)
                      Values (
                            :catNum,
                            :itmNum,
                            :partNum,
                            :description,
                            :qty,
                            :orderID)";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindvalue(':catNum', $itemData['cat_num']);
        $stmt->bindValue(':itmNum', $itemData['itm_num']);
        $stmt->bindValue(':partNum', $itemData['part_num']);
        $stmt->bindValue(':description', $itemData['description']);
        $stmt->bindValue(':qty', $itemData['qty']);
        $stmt->bindValue(':orderID', $itemData['orderID']);
        $stmt->execute();

    }

    /**
    * add these parts to the runboard too
    *
    * @return void
    */
    private static function addRunboard($headerData, $itemData){
        $sql = "INSERT INTO runboard(
                            fromStore,
                            toStore,
                            category,
                            item,
                            description,
                            dateNeeded,
                            storeID,
                            movementType,
                            timeNeeded,
                            itemStatus,
                            notes)
                    VALUES(
                            :fromStore,
                            :toStore,
                            :category,
                            :item,
                            :description,
                            :dateNeeded,
                            :storeID,
                            :movementType,
                            :timeNeeded,
                            :itemStatus,
                            :notes)";
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':fromStore', $headerData['fromStore']);
        $stmt->bindValue(':toStore', $headerData['toStore']);
        $stmt->bindValue(':category', $itemData['cat_num']);
        $stmt->bindValue(':item', $itemData['itm_num']);
        $stmt->bindValue(':description', $itemData['description']);
        $stmt->bindValue(':dateNeeded', 'ASAP');
        $stmt->bindValue(':storeID', $headerData['storeID']);
        $stmt->bindValue(':movementType', 'Inter-Company');
        $stmt->bindValue(':timeNeeded', 'Next Run');
        $stmt->bindValue(':itemStatus', 'Active');
        $stmt->bindValue(':notes', $headerData['transferReason']);

        $stmt->execute();
    }
}