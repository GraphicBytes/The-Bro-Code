<?php


// $fb_id = $_POST['id'];
// $fb_accessToken = $_POST['accessToken'];
// $fb_name = $_POST['name'];
// $fb_email = $_POST['email'];
$email = $fb_email;
$social_id = "fb_" . $fb_id;
$display_name = htmlspecialchars($fb_name, ENT_QUOTES);
$thepassword = hash('sha256', random_str(20) . $websitesalt);
$email_validation_code = random_str(50);
$cookie_id = random_str(100);
$time = time();




//display name
if ($display_name == null or $display_name == "") {
  $display_name = "facebook_user_" . random_str(20);
}
$display_name_check = 0;
$res = $db->sql("SELECT * FROM users WHERE display_name=? ORDER BY id DESC LIMIT 1", "s", $display_name);
while ($row = $res->fetch_assoc()) {
  $display_name_check = 1;
}

if ($display_name_check == 1) {
  $display_name = $display_name . random_str(10);
}



//email check
$duplicate_email_check = 0;
$res = $db->sql("SELECT * FROM users WHERE email=? OR new_email=? ORDER BY id DESC LIMIT 1", 'ss', $email, $email);
while ($row = $res->fetch_assoc()) {
  $duplicate_email_check = 1;
}

if ($duplicate_email_check == 1) {
  $email = NULL;
}



if ($email == NULL) {
  $db->sql("INSERT INTO users SET social_id=?, email_verfied = 1, validation_age=?, password=?, account_type = 1, display_name=?, cookie_id=?, update_profile=1", 'sisss', $social_id, $time, $thepassword, $display_name, $cookie_id);
} else {
  $db->sql("INSERT INTO users SET social_id=?, email=?, email_verfied = 1, validation_age=?, password=?, account_type = 1, display_name=?, cookie_id=?, update_profile=1", 'ssisss', $social_id, $email, $time, $thepassword, $display_name, $cookie_id);
}



$themessage = '<table width="300" style="display:block; width:300px; border:none; margin:20px auto; border-collapse:collapse;"><tr><th>';
$themessage = $themessage . '<img src="' . $smtp_logo . '" style="width:239px; display:block; margin:0 auto 20px auto;" />';
$themessage = $themessage . '<h1 style="color:#0066a3; font-weight:bold; font-size:16pt; display:block; width:80%; text-align:center; padding:0 10% 0 10%; margin:0 0 20px 0;">NEW BRO CODE USER THROUGH FACEBOOK LOGIN</h1>';
$themessage = $themessage . '<p style="color:#222222; font-weight:normal; font-size:10pt; display:block; width:80%; text-align:center; padding:0 10% 0 10%; margin:0 0 20px 0;">' . $display_name . '</p>';
$themessage = $themessage . '</th></tr></table>';
$altbody = 'NEW BRO CODE USER THROUGH FACEBOOK LOGIN - ' . $display_name;

$mysqlquery = "INSERT INTO email_queue SET
  email='kookynetwork@protonmail.com',
  display_name = 'Bro Code Webmaster',
  subject='NEW FACEBOOK USER',
  body='$themessage',
  altbody='$altbody'";
$dbconn->query($mysqlquery);






$res = $db->sql("SELECT * FROM users WHERE social_id=? ORDER BY id DESC LIMIT 1", 's', $social_id);
while ($row = $res->fetch_assoc()) {

  $cookie_id = $row['cookie_id'];
  $user_id = $row['id'];
  $user_email = $row['email'];
  $user_password = $row['password'];
  $login_fail = $row['login_fail'];

  $account_exists = 1;
}




if ($cookie_id == null) {
  $cookie_id = random_str(100);
}
$session_id = random_str(50);

$time = $request_time;

$db->sql("UPDATE users SET cookie_id=?, cookie_age=?, last_login=?, login_fail ='0', cookie_fail='0' WHERE id=?", 'siii', $cookie_id, $time, $time, $user_id);

$db->sql("INSERT INTO active_sessions SET user_id=?, session_id=?, session_timer=?, session_type=0", 'isi', $user_id, $session_id, $time);

$db->sql("DELETE FROM malicious_ips WHERE ip_address=?", 's', $user_ip);
$db->sql("DELETE FROM malicious_useragents WHERE agent_ip=?", 's', $user_ip);

setcookie("brocode_id", $user_id, $request_time + 31536000, "/");
setcookie("brocode_session_key", $session_id, $request_time + 31536000, "/");
setcookie("brocode_session_id", $cookie_id, $request_time + 31536000, "/");








echo '{"response_code":"2","response_message":"NEW ACCOUNT"}';
