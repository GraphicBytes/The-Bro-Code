<?php
$valid_request = 0;

$cleaned_string = $typea;

$mysqlquery = "SELECT * FROM lostpw WHERE request_string='$cleaned_string' ORDER BY id DESC LIMIT 1";
$res = $res = $db->sql("SELECT * FROM lostpw WHERE request_string=? ORDER BY id DESC LIMIT 1", 's', $cleaned_string);
while ($row = $res->fetch_assoc()) {
  $id = $row['id'];
  $request_time = $row['request_time'];
  $user_id = $row['user_id'];
  $valid_request = 1;
}


if ($valid_request == 1) {
  $mysqlquery = "SELECT * FROM users WHERE id='$user_id' ORDER BY id DESC LIMIT 1";
  $res = $dbconn->query($mysqlquery);
  while ($row = $res->fetch_assoc()) {
    $display_name = $row['display_name'];
    $email = $row['email'];
    $email_verified = 1;
  }

  $new_pw = random_str(25);
  $password = hash('sha256', $new_pw . $websitesalt);

  $cookie_id = random_str(100);
  $time = time();

  $mysqlquery = "UPDATE users SET password='$password', cookie_id='$cookie_id', cookie_age='$time', login_fail ='0', cookie_fail='0' WHERE id='$user_id'";
  $dbconn->query($mysqlquery);

  $themessage = '<table width="300" style="display:block; width:300px; border:none; margin:20px auto; border-collapse:collapse;"><tr><th>';
  $themessage = $themessage . '<img src="' . $smtp_logo . '" style="width:239px; display:block; margin:30px auto 30px auto;" />';
  $themessage = $themessage . '<h1 style="color:#0066a3; font-weight:bold; font-size:16pt; display:block; width:80%; text-align:center; padding:0 10% 0 10%; margin:0 0 20px 0;">YOUR PASSWORD HAS BEEN RESET</h1>';
  $themessage = $themessage . '<p style="color:#222222; font-weight:normal; font-size:11pt; display:block; width:80%; text-align:center; padding:0 10% 0 10%; margin:0 0 20px 0;">You can log into your account with the following password:</p>';
  $themessage = $themessage . '<p style="color:#0066a3; font-weight:bold; text-decoration:none; font-size:12pt; display:block; width:80%; text-align:center; padding:0 10% 0 10%; margin:0 0 20px 0;">' . $new_pw . '</p>';
  $themessage = $themessage . '<a href="' . $base_url . '" style="color:#222222; font-weight:bold; text-decoration:none; font-size:11pt; display:block; width:80%; text-align:center; padding:0 10% 0 10%; margin:0 0 20px 0;">www.brocode.org</a>';
  $themessage = $themessage . '<p style="color:#222222; font-weight:normal; font-size:10pt; display:block; width:80%; text-align:center; padding:0 10% 0 10%; margin:0 0 20px 0;">Please login and change your password.</p>';
  $themessage = $themessage . '</th></tr></table>';


  $altbody = 'YOUR PASSWORD HAS BEEN RESET! You can log into your account with the following password: ' . $new_pw;

  $mysqlquery = "INSERT INTO email_queue SET
  email='$email',
  display_name = '$display_name',
  subject='Your password has been reset',
  body='$themessage',
  altbody='$altbody'";
  $dbconn->query($mysqlquery);

  $mysqlquery = "DELETE FROM lostpw WHERE id='$id'";
  $dbconn->query($mysqlquery);

  $location = "Location: " . $base_url . "/pwreset/";
} else {
  $location = "Location: " . $base_url;
}

header($location);
exit();
