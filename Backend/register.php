<?php
/**
 * Created by PhpStorm.
 * User: Johnno
 * Date: 7-6-2015
 * Time: 22:03
 */
header('Content-Type: application/json');
// response json
$json = array();


$json = file_get_contents('php://input');
$obj = json_decode($json);


/**
 * Registering a user device
 * Store reg id in users table
 */
if (isset($obj->user)  && isset($obj->token)) {
    $name = $obj->user;
    $gcm_regid = $obj->token; // GCM Registration ID
    // Store user details in db
    include_once './db_functions.php';
    include_once './GCM.php';

    $db = new DB_Functions();
    $gcm = new GCM();

    $res = $db->storeUser($name, $gcm_regid);

    $registatoin_ids = array($gcm_regid);
    $message = array("product" => "shirt");

    $result = $gcm->send_notification($registatoin_ids, $message);

    //echo json_encode(array("data" => $result ));
} else {
    // user details missing
}