<?php
$csrf_token = $_POST['csrf_token'];
$token_check = $tokens->check_token($csrf_token);
if ($token_check == 1) {

  $email = $_POST['email'];
  $halt = 0;


  if (is_malicious() or $token_check == 0) {
    $halt = 1;
    log_malicious();
    echo '{"response_code":"0","response_message":"UNKNOWN ERROR"}';
  }


  //Check for blocked emails
  if ($halt == 0) {
    $email_check = 0;
    $res = $db->sql("SELECT * FROM blocked_emails ORDER BY id ASC");
    while ($row = $res->fetch_assoc()) {
      $blacklisted_domain = $row['email'];
      if (str_contains($email, $blacklisted_domain)) {
        $email_check = 1;
        $triggered_domain = $blacklisted_domain;
      }
    }

    if ($email_check == 1) {
      $halt = 1;
      echo '{"response_code":"0","response_message":"OUR EMAILS TO @' . strtoupper($triggered_domain) . ' ADDRESSES ARE BLOCKED, CAN YOU USE A DIFFERENT ONE? SORRY BRO!"}';
    }
  }


  //Check valid email
  if ($halt == 0) {
    $email_check = 0;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_check = 1;
    }
    if ($email_check == 1) {
      $halt = 1;
      log_malicious();
      echo '{"response_code":"0","response_message":"INVALID EMAIL"}';
    }
  }

  if ($halt == 0) {

    //Check if email exits
    $email_valid = 0;
    $res = $db->sql("SELECT * FROM users WHERE email=? AND email_verfied=1 ORDER BY id DESC LIMIT 1", 's', $email);
    while ($row = $res->fetch_assoc()) {

      $email_valid = 1;

      $request_time = time();
      $request_string = random_str(50);

      $user_id = $row['id'];
      $user_email = $row['email'];
      $user_display_name = $row['display_name'];
    }

    if ($email_valid == 1) {
      $mysqlquery = "SELECT * FROM lostpw WHERE user_id='$user_id'";
      $res = $dbconn->query($mysqlquery);
      while ($row = $res->fetch_assoc()) {
        $halt = 1;

        log_malicious();

        echo '{"response_code":"1","response_message":"ALREADY REQUESTED! CHECK YOUR SPAM FOLDER OR WAIT 15 MINUTES AND TRY AGAIN!"}';
      }
    } else {
      $halt = 1;
      echo '{"response_code":"1","response_message":"ERROR! IF YOU SIGNED UP AND DIDN\'T RECIEVE AN EMAIL, PLEASE CHECK YOUR SPAM!"}';

      log_malicious();
    }
  }




  if ($halt == 0) {

    $mysqlquery = "INSERT INTO lostpw SET request_time='$request_time',  request_string='$request_string',  ip='$user_ip',  user_id='$user_id'";
    $res = $dbconn->query($mysqlquery);


    $themessage = '<table width="300" style="display:block; width:300px; border:none; margin:20px auto; border-collapse:collapse;"><tr><th>';
    $themessage = $themessage . '<img src="' . $smtp_logo . '" style="width:239px; display:block; margin:30px auto 30px auto;" />';
    $themessage = $themessage . '<h1 style="color:#0066a3; font-weight:bold; font-size:16pt; display:block; width:80%; text-align:center; padding:0 10% 0 10%; margin:0 0 20px 0;">PASSWORD RESET REQUEST</h1>';
    $themessage = $themessage . '<p style="color:#222222; font-weight:normal; font-size:11pt; display:block; width:80%; text-align:center; padding:0 10% 0 10%; margin:0 0 20px 0;">A request to reset your password was submitted using the IP address ' . $user_ip . '. If you did not request a password change please ignore this email, otherwise follow the following link to reset your password.</p>';
    $themessage = $themessage . '<a href="' . $base_url . '/resetpw/' . $request_string . '/" style="color:#0066a3; font-weight:bold; text-decoration:none; font-size:12pt; display:block; width:80%; text-align:center; padding:0 10% 0 10%; margin:0 0 20px 0;">CLICK HERE TO RESET YOUR PASSWORD</a>';
    $themessage = $themessage . '<p style="color:#222222; font-weight:normal; font-size:10pt; display:block; width:80%; text-align:center; padding:0 10% 0 10%; margin:0 0 20px 0;">This reset link is only valid for 15 minutes!</p>';
    $themessage = $themessage . '</th></tr></table>';


    $altbody = 'A request to reset your password was submitted using the IP address ' . $user_ip . '. If you did not request a password change please ignore this email, otherwise visit this URL reset your password: ' . $base_url . '/resetpw/' . $request_string . '/';

    $mysqlquery = "INSERT INTO email_queue SET
      email='$user_email',
      display_name = '$user_display_name',
      subject='Password Reset Request',
      body='$themessage',
      altbody='$altbody'";

    if ($user_email != NULL or $user_email != "") {
      $dbconn->query($mysqlquery);
    }

    echo '{"response_code":"1","response_message":"THANK YOU, PLEASE CHECK YOUR EMAIL"}';

    $halt = 1;
  }


  if ($halt == 0) {
    log_malicious();

    echo '{"response_code":"1","response_message":"THANK YOU, PLEASE CHECK YOUR EMAIL"}';
  }
} else {

  log_malicious();

  echo '{"response_code":"0","response_message":"UNKNOWN ERROR"}';
}
