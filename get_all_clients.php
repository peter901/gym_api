<?php
 
/*
 * Following code will list all the clients
 */
 
// array for JSON response
$response = array();
 
// include db connect class
require_once __DIR__ . '/db_connect.php';
 
// connecting to db
$db = new DB_CONNECT();
 
// get all clients from clients table
//$result = mysql_query("SELECT * FROM agym_record") or die(mysql_error());
$result = mysql_query("SELECT id ,names, amount, DATE(date) AS dates, TIME(date) AS time,instructor_id FROM agym_record") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // clients node
    $response["clients"] = array();
 
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $client = array();
        $client["cid"] = $row["id"];
        $client["names"] = $row["names"];
        $client["amount"] = $row["amount"];
//        $client["date"] = $row["date"];
        $client["date"] = date('D, j-M-Y',strtotime($row["dates"])).' '.$row["time"];
        $instructor_id = $row["instructor_id"];
		$sql1=mysql_query("SELECT name FROM agym_instructor where id='$instructor_id'");
		$client["instructor_name"] = mysql_result($sql1,0,0);	
		
        // push single client into final response array
        array_push($response["clients"], $client);
    }
    // success
    $response["success"] = 1;
 
    // echoing JSON response
    echo json_encode($response);
} else {
    // no clients found
    $response["success"] = 0;
    $response["message"] = "No clients found";
 
    // echo no users JSON
    echo json_encode($response);
}
?>