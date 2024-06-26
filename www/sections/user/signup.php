<?php
$csrf_token = $_POST['csrf_token'];
$csrf_check = $tokens->check_token($csrf_token);

$tokens->set_spam_tokens($system_data['anti_spam_tokens']);
$anti_spam_check = $tokens->check_spam_token($typea);

if ($anti_spam_check == 1) {

  if ($csrf_check == 1) {

    $display_name = htmlspecialchars($_POST['display_name'], ENT_QUOTES);
    $email = $_POST['email'];
    $passworda = $_POST['passworda'];
    $passwordb = $_POST['passwordb'];
    $halt = 0;


    if (is_malicious()) {

      log_malicious();

      echo '{"response_code":"1","response_message":"PLEASE CHECK YOUR EMAIL"}';
      $halt = 1;
    }





    //is displayname set
    if ($halt == 0) {
      if ($display_name == null or $display_name == "") {
        $halt = 1;
        echo '{"response_code":"0","response_message":"PLEASE SELECT A DISPLAY NAME"}';
      }
    }

    //Check duplicate display name
    if ($halt == 0) {
      $display_name_check = 0;
      $res = $db->sql("SELECT * FROM users WHERE display_name=? ORDER BY id DESC LIMIT 1", "s", $display_name);
      while ($row = $res->fetch_assoc()) {
        $display_name_check = 1;
      }

      if ($display_name_check == 1) {
        $halt = 1;
        log_malicious();
        echo '{"response_code":"0","response_message":"DISPLAY NAME TAKEN"}';
      }
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
        log_malicious();
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


    //Check if email is taken
    if ($halt == 0) {
      $duplicate_email_check = 0;
      $res = $db->sql("SELECT * FROM users WHERE email=? OR new_email=? ORDER BY id DESC LIMIT 1", 'ss', $email, $email);
      while ($row = $res->fetch_assoc()) {
        $duplicate_email_check = 1;
      }

      if ($duplicate_email_check == 1) {
        $halt = 1;
        log_malicious();
        echo '{"response_code":"0","response_message":"EMAIL ALREADY IN USE"}';
      }
    }

    //password length
    if ($halt == 0) {
      $passwordlength = strlen($passworda);
      if ($passwordlength < 6) {
        $halt = 1;
        echo '{"response_code":"0","response_message":"PASSWORD MUST BE AT LEAST 6 CHARACTERS"}';
      }
    }
    //password match
    if ($halt == 0) {
      if ($passworda != $passwordb) {
        $halt = 1;

        echo '{"response_code":"0","response_message":"PASSWORDS DO NOT MATCH"}';
      }
    }

    //#####################################
    //########## CREATE NEW USER ##########
    //#####################################
    if ($halt == 0) {

      $thepassword = hash('sha256', $passwordb . $websitesalt);
      $email_validation_code = random_str(50);
      $cookie_id = random_str(100);
      $time = time();

      $db->sql("INSERT INTO users SET email=?,email_verfied = 0, email_validation_code=?, validation_age=?, password=?, account_type = 1, display_name=?, cookie_id=?", 'ssisss', $email, $email_validation_code, $time, $thepassword, $display_name, $cookie_id);

      $themessage = '<table width="300" style="display:block; width:300px; border:none; margin:20px auto; border-collapse:collapse;"><tr><th>';
      $themessage = $themessage . '<img src="' . $smtp_logo . '" style="width:239px; display:block; margin:30px auto 30px auto;" />';
      $themessage = $themessage . '<h1 style="color:#0066a3; font-weight:bold; font-size:16pt; display:block; width:80%; text-align:center; padding:0 10% 0 10%; margin:0 0 20px 0;">PLEASE VALIDATE YOUR EMAIL</h1>';
      $themessage = $themessage . '<p style="color:#222222; font-weight:normal; font-size:11pt; display:block; width:80%; text-align:center; padding:0 10% 0 10%; margin:0 0 20px 0;">You have requested sign up to The Bro Code using this email address. Please follow the link to validate your email and finalise your sign up.</p>';
      $themessage = $themessage . '<a href="' . $base_url . '/signupvalidate/' . $email_validation_code . '/" style="color:#0066a3; font-weight:bold; text-decoration:none; font-size:12pt; display:block; width:80%; text-align:center; padding:0 10% 0 10%; margin:0 0 20px 0;">CLICK HERE TO VERIFY EMAIL</a>';
      $themessage = $themessage . '<p style="color:#222222; font-weight:normal; font-size:10pt; display:block; width:80%; text-align:center; padding:0 10% 0 10%; margin:0 0 20px 0;">The verification URL will only be valid for 48 hours, after that you will need to start this process again.</p>';
      $themessage = $themessage . '</th></tr></table>';


      $altbody = 'You have requested sign up to The Bro Code using this Email address. Please follow the link to validate your email and finalise your sign up. Please visit this URL to validate your new Email and finish your requested change: ' . $base_url . '/signupvalidate/' . $email_validation_code . '/';

      $db->sql("INSERT INTO email_queue SET email=?, display_name = ?, subject='Please validate your email', body=?, altbody=?", 'ssss', $email, $display_name, $themessage, $altbody);


      $halt = 1;
      echo '{"response_code":"1","response_message":"PLEASE CHECK YOUR EMAIL"}';
    }

    if ($halt == 0) {
      log_malicious();
      echo '{"response_code":"0","response_message":"UNKNOWN ERROR"}';
    }
  } else {

    log_malicious();
    echo '{"response_code":"0","response_message":"UNKNOWN ERROR"}';
  }
} else {

  log_malicious();
  echo '{"response_code":"1","response_message":"PLEASE CHECK YOUR EMAIL"}';
}
