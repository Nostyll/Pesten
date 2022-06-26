<?php
/**
 * Created by PhpStorm.
 * User: Johnno
 * Date: 7-6-2015
 * Time: 22:04
 */

if (isset($_GET["regId"]) && isset($_GET["message"])) {
    $regId = $_GET["regId"];
    $message = rawurldecode($_GET["message"]);

    include_once './GCM.php';

    $gcm = new GCM();

    $registatoin_ids = array($regId);

    $result = $gcm->send_notification($registatoin_ids, $message);

    echo $result;

    echo "<br>";

    echo $message;
}