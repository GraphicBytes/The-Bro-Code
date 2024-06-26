<?php
$choice = $typea;
$query = "UPDATE users SET view_order='$choice' WHERE id='$logged_in_id'";
$res = $dbconn->query($query);

$return_arr = array("status" => "1");
echo json_encode($return_arr);
