<?php

// Disposal form Model. Mostly a copy of the purchasing App

namespace App\Models;

use PDO;
use App\Mail;
use APP\Auth;

class Disposal_m extends \Core\Model
{
    /** 
    *   Set up the email 1st.
    *   TODO:
    *   pull email data from a database field
    */
    public static function sendEmail($data) {

    // get user data to fill in automatically
    $user = Auth::getUser();
    // Email Settings
    // Send email back to user and the home store    
    $cc[] = $user->email;

    // Live Address
    $to = 'disposal@chetsrentall.com';
    // Test address
    //$to = 'jgransden@chetsrentall.com';

    // getting the From store email
    $allStores = Helpers::getStores();
    foreach ($allStores as $store) {
        if ($store['storeNumber'] == $user->storeNumber){
            //uncomment for Live
            //$cc[] = ($store['storeEmail']);
            $storeName = $store['storeName'];
        }

    }
    // HTML Email Version
    $partCount = count($data['catNum']);
    $msgHeader = '<b>Store Requesting: &emsp;</b>' . $storeName . '<br />';
    $msgHeader .= '<b>Requestor: &emsp;</b>' . $user->name . '<br />';
    $msgHeader .= '<b><h3>If Stolen</h3></b>';
    $msgHeader .= '<b>Police Department: &emsp;</b>' . $data['policeDepartment'] . '<br />';
    $msgHeader .= '<b>Date Reported to Police: &emsp;</b>' . $data['policeDate'] . '<br />';
    $msgHeader .= '<b>Police Report Number: &emsp;</b>' . $data['reportNum'] . '<br />';
    $msgHeader .= '<b>Reported to NER by: &emsp;</b>' .  $data['nerReportBy'] . '<br />';
    $msgHeader .= '<b>Date Reported to NER: &emsp;</b>' . $data['nerDate'] . '<br />';
    $msgHeader .= '<b>Reported to Manufacturer by: &emsp;</b>' . $data['mfgReportBy'] . '<br />';
    $msgHeader .= '<b>Date Reported to Manufacturer: &emsp;</b>' . $data['mfgDate'] . '<br />';

    $msgFooter = '<h3>Details of the Disposal</h3>' . $data['disposal_comments'];
    $msg = '<h3>Disposal Item Line Details</h3>';
    $msg .= '<table border="1"><tr><b><td>Cat Num</td><td>Item Num</td><td>Serial Num</td><td>Manufacturer</td><td>Qty</td><td>Disposal Type</td></b></tr>';
    for ($i = 0;$i<$partCount; $i++){
        $msg .= "<tr>";
        $msg .= "<td>" . $data['catNum'][$i] . "</td>";
        $msg .= "<td>" . $data['itmNum'][$i] . "</td>";
        $msg .= "<td>" . $data['serialNum'][$i] . "</td>";
        $msg .= "<td>" . $data['mfg'][$i] . "</td>";
        $msg .= "<td>" . $data['quantity'][$i] . "</td>";
        $msg .= "<td>" . $data['disposalCode'][$i] . "</td>";
        $msg .= "</tr>";
    }
    $msg .="</table>";

    // Text only part of the email

    $textHeader = "Store Requesting: " . $storeName . "\r\n";
    $textHeader .= "Requestor: " . $user->name . "\r\n\r\n";
    $textHeader .= "If Stolen: \r\n\r\n";
    $textHeader .= "Police Department: " . $data['policeDepartment'] . "\r\n";
    $textHeader .= "Date Reported to Police" . $data['policeDate'] . "\r\n";
    $textHeader .= "Police Report Number: " . $data['reportNum'] . "\r\n";
    $textHeader .= "Reported to NER by: " . $data['nerReportBy'] . "\r\n";
    $textHeader .= "Date Reported to NER" . $data['nerDate'] . "\r\n";
    $textHeader .= "Reported to Manufacturer by: " . $data['mfgReportBy'] . "\r\n";
    $textHeader .= "Date Reported to Manufacturer: " . $data['mfgDate'] . "\r\n";

    $textFooter = 'Details of the Disposal \r\n' . $data['disposal_comments'];
    $textBody = "Cat # Item # Serial # Manufacturer Quantity Disposal Type";

    for ($i = 0; $i<$partCount; $i++){
        $textBody .= $data['catNum'][$i] . ' ';
        $textBody .= $data['itmNum'][$i] . ' ';
        $textBody .= $data['serialNum'][$i] . ' ';
        $textBody .= $data['mfg'][$i] . ' ';
        $textBody .= $data['quantity'][$i] . ' ';
        $textBody .= $data['disposalCode'][$i] . ' ';
    }

    $subject = 'New Disposal Request';
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
    public static function saveDisposal($data){

    // Create some constants for the sql inserts
        $user = Auth::getUser();
        // Save order Header
        $reqStrore = $user->storeNumber;
        $userID = $user->id;




        $sql = "INSERT INTO disposal_head (
                        reqStore,
                        userRequesting,
                        policeName,
                        policeReportDate,
                        policeReportNum,
                        nerReportBy,
                        nerReportDate,
                        mfgReportBy,
                        mfgReportDate,
                        disposalComments)
                  Values (
                        :reqStore,
                        :userRequesting,
                        :policeName,
                        :policeReportDate,
                        :policeReportNum,
                        :nerReportBy,
                        :nerReportDate,
                        :mfgReportBy,
                        :mfgReportDate,
                        :disposalComments)";
            
        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':reqStore', $reqStrore);
        $stmt->bindValue(':userRequesting', $userID);
        $stmt->bindValue(':policeName', $data['policeDepartment']);
        $stmt->bindValue(':policeReportDate', $data['policeDate']);
        $stmt->bindValue(':policeReportNum', $data['reportNum']);
        $stmt->bindValue(':nerReportBy', $data['nerReportBy']);
        $stmt->bindValue(':nerReportDate', $data['nerDate']);
        $stmt->bindValue(':mfgReportBy', $data['mfgReportBy']);
        $stmt->bindValue(':mfgReportDate', $data['mfgDate']);
        $stmt->bindValue(':disposalComments', $data['disposal_comments']);

        $stmt->execute();

        // Get id of last insert
        $insertId = $db->lastinsertId();
        // get total number of parts for the order

        $partCount = count($data['catNum']);

        // save each item on the request to table
        for ($i = 0; $i<$partCount; $i++){
            $itemData = array(
                'cat_num' => $data['catNum'][$i],
                'itm_num' => $data['itmNum'][$i],
                'ser_num' => $data['serialNum'][$i],
                'mfg' =>     $data['mfg'][$i],
                'qty' =>     $data['quantity'][$i],
                'disp_code'=>$data['disposalCode'][$i],
                'orderID' => $insertId
            );
            static::saveParts($itemData);
        }
    }

    /**
    * Save the Parts
    *
    * @return void
    */
    private static function saveParts($itemData){
        // make sure column names are correct
        $sql = "INSERT INTO disposal_detail(
                            catNum,
                            itmNum,
                            serialNum,
                            mfg,
                            qty,
                            disposalType,
                            disposalNum)
                      Values (
                            :catNum,
                            :itmNum,
                            :serNum,
                            :mfg,
                            :qty,
                            :disposalCode,
                            :orderID)";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindvalue(':catNum', $itemData['cat_num']);
        $stmt->bindValue(':itmNum', $itemData['itm_num']);
        $stmt->bindValue(':serNum', $itemData['ser_num']);
        $stmt->bindValue(':mfg', $itemData['mfg']);
        $stmt->bindValue(':qty', $itemData['qty']);
        $stmt->bindValue(':disposalCode', $itemData['disp_code']);
        $stmt->bindValue(':orderID', $itemData['orderID']);
        $stmt->execute();

    }
}