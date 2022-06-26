<?php

include_once './db_connect.php';
// connecting to database
$con = new DB_Connect();
$testLocs = array();

//if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if (isset($_GET['timestamp'])) {
        $timestamp = $_GET['timestamp'];
    }
    if ($result = mysqli_query($con->connect(),'SELECT `created_at` FROM gcm_users ORDER BY created_at DESC LIMIT 1;')) {
        while (mysqli_fetch_array($result)) {
                //echo $time - $timestamp;
                if ($timestamp == 0) {
                    $testLocs['newdata'] = array('newdata' => 2);
                } elseif (($time - $timestamp) >= 1) {
                    $testLocs['newdata'] = array('newdata' => 1);
                }
            }
    }
    echo "<pre>";
echo print_r($testLocs);
//}///einde van de check de http
?>
    if (dbConn::prepare('SELECT `time` FROM coordinaten ORDER BY time DESC LIMIT 1;')){
        if(dbConn::execute()){
            dbConn::stmt()->bindColumn("time", $time);
            while(dbConn::single(PDO::FETCH_ASSOC)){
                //echo $time - $timestamp;
                if ($timestamp == 0){
                    $testLocs['newdata'] = array('newdata' => 2);
                }elseif (($time - $timestamp) >= 1){
                    $testLocs['newdata'] = array('newdata' => 1);
                }
            }
        }
    }

    if (dbConn::prepare('SELECT `id`, `desc`, `lat`, `lon`, `time`, `img`, `groep`  FROM coordinaten ORDER BY time DESC;')){
        if(dbConn::execute()){
            dbConn::stmt()->bindColumn("id", $id);
            dbConn::stmt()->bindColumn("desc", $desc);
            dbConn::stmt()->bindColumn("lat", $lat);
            dbConn::stmt()->bindColumn("lon", $lon);
            dbConn::stmt()->bindColumn("time", $time);
            dbConn::stmt()->bindColumn("img", $img);
            dbConn::stmt()->bindColumn("groep", $groep);
            while(dbConn::single(PDO::FETCH_ASSOC)){
                switch($img){
                    case 1:
                        $imges = "new";
                        break;
                    case 0:
                        $imges = "";
                        break;
                }
                $date =  date('Y-m-d H:i:s', $time);
                $testLocs['loc'.$id] = array( 'info' =>$date.'<br>'.$desc, 'lat' => $lat, 'lng' => $lon, 'img' => $imges, 'groep' => $groep  );
            }

        }
        $testLocs['newtime'] = array('newtime' => time());
    }
//echo "<pre>";
//print_r($testLocs);
    echo json_encode($testLocs);
    exit();
}
?>