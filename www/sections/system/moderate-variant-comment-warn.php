<?php
$comment_id = $typea;
$owner_id = $typeb;


//get the content
$mysqlquery3 = "SELECT id, code_id, content FROM variant_comments WHERE id='$typea' ORDER BY id DESC LIMIT 1";
$res3 = $dbconn->query($mysqlquery3);
while ($row3 = $res3->fetch_assoc()) {
  $content = $row3['content'];
  $code_id = $row3['code_id'];
}

$title = "You have been given a warning!";
$message = "<h2>" . $content . "</h2>";
$message = htmlspecialchars($message, ENT_QUOTES);

// 1 = code
// 2 = code varients
// 3 = code varient comment
// 4 = board topic
// 5 = board reply
// 6 = Meme
$section = 3;
$section_id = $code_id;


// 1 = just deleted
// 2 = warned
// 3 = banned
$type = 2;

//set notification
$mysqlquery3 = "INSERT INTO notifications SET title='$title', user_id='$owner_id', message='$message', section='$section', section_id='$section_id', type='1'";
$dbconn->query($mysqlquery3);




//add the warning tally
$mysqlquery3 = "UPDATE users SET warnings=warnings+1 WHERE id='$owner_id'";
$dbconn->query($mysqlquery3);

//get user warnings
$mysqlquery3 = "SELECT * FROM users WHERE id='$owner_id' ORDER BY id DESC LIMIT 1";
$res3 = $dbconn->query($mysqlquery3);
while ($row3 = $res3->fetch_assoc()) {
  $warnings = $row3['warnings'];
}





if ($warnings > 2) {
  include($php_base_directory . '/sections/system/includes/ban_user.php');
} else {
  include($php_base_directory . '/sections/system/includes/delete_variant_comments.php');
}






$return_arr = array("status" => 1, "ids" => $ids);
echo json_encode($return_arr);
