<?php

$validation_age = time() - 172800;
$email_verified = 0;

$verify_sting = $typea;

$mysqlquery = "SELECT * FROM users WHERE email_validation_code='$verify_sting' AND validation_age > $validation_age ORDER BY id DESC LIMIT 1";
$res = $dbconn->query($mysqlquery);
while ($row = $res->fetch_assoc()) {

  $display_name = $row['display_name'];
  $email = $row['email'];

  $user_id = $row['id'];
  $email_verified = 1;
}

if ($email_verified == 1) {

  $mysqlquery = "UPDATE users SET
  email_verfied = 1
  WHERE id='$user_id'";
  $dbconn->query($mysqlquery);

  $themessage = '<table width="300" style="display:block; width:300px; border:none; margin:20px auto; border-collapse:collapse;"><tr><th>';
  $themessage = $themessage . '<img src="' . $smtp_logo . '" style="width:239px; display:block; margin:0 auto 20px auto;" />';
  $themessage = $themessage . '<h1 style="color:#0066a3; font-weight:bold; font-size:16pt; display:block; width:80%; text-align:center; padding:0 10% 0 10%; margin:0 0 20px 0;">THANK YOU, YOUR EMAIL HAS BEEN CONFIRMED</h1>';
  $themessage = $themessage . '<p style="color:#222222; font-weight:normal; font-size:10pt; display:block; width:80%; text-align:center; padding:0 10% 0 10%; margin:0 0 20px 0;">You have successfully confirmed your email address. You can now use it to log into The Bro Code.</p>';
  $themessage = $themessage . '</th></tr></table>';
  $altbody = 'THANK YOU, YOUR EMAIL HAS BEEN CONFIRMED! You have successfully confirmed your email address. You can now use it to log into The Bro Code.';

  $mysqlquery = "INSERT INTO email_queue SET
  email='$email',
  display_name = '$display_name',
  subject='Thank you for confirming your email',
  body='$themessage',
  altbody='$altbody'";
  $dbconn->query($mysqlquery);



  $themessage = '<table width="300" style="display:block; width:300px; border:none; margin:20px auto; border-collapse:collapse;"><tr><th>';
  $themessage = $themessage . '<img src="' . $smtp_logo . '" style="width:239px; display:block; margin:0 auto 20px auto;" />';
  $themessage = $themessage . '<h1 style="color:#0066a3; font-weight:bold; font-size:16pt; display:block; width:80%; text-align:center; padding:0 10% 0 10%; margin:0 0 20px 0;">NEW BROCODE USER</h1>';
  $themessage = $themessage . '<p style="color:#222222; font-weight:normal; font-size:10pt; display:block; width:80%; text-align:center; padding:0 10% 0 10%; margin:0 0 20px 0;">' . $display_name . '</p>';
  $themessage = $themessage . '</th></tr></table>';
  $altbody = 'NEW BROCODE USER - ' . $display_name;

  $mysqlquery = "INSERT INTO email_queue SET
  email='kookynetwork@protonmail.com',
  display_name = 'Bro Code Webmaster',
  subject='NEW USER',
  body='$themessage',
  altbody='$altbody'";
  $dbconn->query($mysqlquery);


  $db->sql("UPDATE users SET email_validation_code=NULL WHERE id=?", 'i', $user_id);


  $location = "Location: " . $base_url . "/nowsignedup/";
} else {
  $location = "Location: " . $base_url;
}



header($location);
exit();
