<?php
$comment_id = $typea;
$owner_id = $typeb;


//get the content
$mysqlquery3 = "SELECT id, code_id, content FROM thecode_examples WHERE id='$typea' ORDER BY id DESC LIMIT 1";
$res3 = $dbconn->query($mysqlquery3);
while ($row3 = $res3->fetch_assoc()) {
  $content = $row3['content'];
  $code_id = $row3['code_id'];
}

$title = "Your comment has been deleted";
$message = "<h2>" . $content . "</h2>";
$message = htmlspecialchars($message, ENT_QUOTES);

// 1 = code
// 2 = code varients
// 3 = code varient comment
// 4 = board topic
// 5 = board reply
// 6 = Meme
$section = 1;
$section_id = $code_id;

$type = 1;

//set notification
$mysqlquery3 = "INSERT INTO notifications SET title='$title', user_id='$owner_id', message='$message', section='$section', section_id='$section_id', type='1'";
$dbconn->query($mysqlquery3);






//delete comments
include($php_base_directory . '/sections/system/includes/delete_comments.php');








$return_arr = array("status" => 1, "ids" => $ids);
echo json_encode($return_arr);
