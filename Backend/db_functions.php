<?php
/**
 * Created by PhpStorm.
 * User: Johnno
 * Date: 7-6-2015
 * Time: 22:01
 */

class DB_Functions {

    private $db;

    //put your code here
    // constructor
    function __construct() {
        include_once './db_connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }

    // destructor
    function __destruct() {

    }

    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $gcm_regid) {
        $time = time();

        // insert user into database
        $result = mysqli_query($this->db->connect(), "INSERT INTO gcm_users(name, gcm_regid, created_at) VALUES('$name', '$gcm_regid', '$time')");

        // check for successful store
        if ($result) {
            // get user details
            $id = mysqli_insert_id($result); // last inserted id
            $result = mysqli_query($this->db->connect(),"SELECT * FROM gcm_users WHERE id = $id") or die(mysql_error());
            // return user details
            if (mysqli_num_rows($result) > 0) {
                return mysqli_fetch_array($result);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Getting all users
     */
    public function getAllUsers() {
        $result = mysqli_query($this->db->connect(),"select * FROM gcm_users");
        return $result;
    }

}