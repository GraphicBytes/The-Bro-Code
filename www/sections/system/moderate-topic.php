<?php

$topic_id = $typea;
$rating = $typeb;



$mysqlquery = "UPDATE topics SET status='1', sfw='$typeb' WHERE id='$typea'";
$dbconn->query($mysqlquery);


$return_arr = array("status" => 1, "id" => $typea, "rating" => $typeb);
echo json_encode($return_arr);
