<?php
 
/*
 * Following code will list all the date
 */
 
// array for JSON response
$response = array();
 
// include db connect class
require_once __DIR__ . '/db_connect.php';
 
// connecting to db
$db = new DB_CONNECT();
 
// get all date from date table
$result = mysql_query("SELECT DISTINCT(DATE(date)) AS date FROM `agym_record`") or die(mysql_error());
 
// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // date node
    $response["date"] = array();
 
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $date = array();
        $date["date"] = $row["date"];
			
        // push single date into final response array
        array_push($response["date"], $date);
    }
    // success
    $response["success"] = 1;
 
    // echoing JSON response
    echo json_encode($response);
} else {
    // no date found
    $response["success"] = 0;
    $response["message"] = "No date found";
 
    // echo no users JSON
    echo json_encode($response);
}
?>