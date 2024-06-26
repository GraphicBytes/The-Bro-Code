<?php

if ($typea == "email") {

  $csrf_token = $_POST['csrf_token'];
  $token_check = $tokens->check_token($csrf_token);

  if (is_malicious() or $token_check == 0) {

    log_malicious();

    echo '{"response_code":"2","response_message":"INCORRECT PASSWORD"}';
  } else {

    $email = $_POST['email'];
    $remember_me = $_POST['remember_me'];

    $referer = $_POST['bounceback'];

    $password = $_POST['password'];
    $password = hash('sha256', $password . $websitesalt);

    $account_exists = 0;

    $res = $db->sql("SELECT * FROM users WHERE email=? ORDER BY id DESC LIMIT 1", 's', $email);
    while ($row = $res->fetch_assoc()) {

      $cookie_id = $row['cookie_id'];
      $user_id = $row['id'];
      $user_email = $row['email'];
      $user_password = $row['password'];
      $login_fail = $row['login_fail'];

      $account_exists = 1;
    }

    //does account exist
    if ($account_exists == 1 and $login_fail < 10) {

      if ($cookie_id == null) {
        $cookie_id = random_str(100);
      }
      $session_id = random_str(50);

      //does password match
      if ($password == $user_password) {

        $time = $request_time;

        $db->sql("UPDATE users SET cookie_id=?, cookie_age=?, last_login=?, login_fail ='0', cookie_fail='0' WHERE id=?", 'siii', $cookie_id, $time, $time, $user_id);

        $db->sql("INSERT INTO active_sessions SET user_id=?, session_id=?, session_timer=?, session_type=?", 'isii', $user_id, $session_id, $time, $remember_me);

        $db->sql("DELETE FROM malicious_ips WHERE ip_address=?", 's', $user_ip);
        $db->sql("DELETE FROM malicious_useragents WHERE agent_ip=?", 's', $user_ip);

        setcookie("brocode_id", $user_id, $request_time + 31536000, "/");
        setcookie("brocode_session_key", $session_id, $request_time + 31536000, "/");
        setcookie("brocode_session_id", $cookie_id, $request_time + 31536000, "/");

        echo '{"response_code":"1","response_message":"SUCCESS"}';
      } else {

        if ($_POST['password'] == "") {
        } else {
          $login_fail = $login_fail + 1;
        }

        $mysqlquery = "UPDATE users SET login_fail ='$login_fail' WHERE id='$user_id'";
        $dbconn->query($mysqlquery);

        log_malicious();

        echo '{"response_code":"2","response_message":"INCORRECT PASSWORD"}';
      }
    } else { //account does not exist
      echo '{"response_code":"3","response_message":"NO ACCOUNT REGISTERED WITH THAT EMAIL"}';

      log_malicious();
    }
  }
} elseif ($typea == "facebook") {

  if (is_malicious()) {

    log_malicious();

    echo '{"response_code":"4","response_message":"ERROR"}';
  } else {

    $fb_error = 0;

    $fb_id = $_POST['id'];
    $fb_accessToken = $_POST['accessToken'];
    $fb_name = $_POST['name'];
    $fb_email = $_POST['email'];

    require_once $php_base_directory . '/functions/facebook/autoload.php';
    $fb = new \Facebook\Facebook([
      'app_id' => $fb_app_id,
      'app_secret' => $fb_app_secret,
      'default_graph_version' => $fb_default_graph_version,
      //'default_access_token' => '{access-token}', // optional
    ]);

    try {
      $response = $fb->get('/me', $fb_accessToken);
    } catch (Throwable $e) {
      $fb_error = 1;
    }

    if ($fb_error == 0) {
      $graphNode = $response->getGraphNode();
      if ($fb_id != $graphNode['id']) {
        $fb_error == 1;
      }
    }


    if ($fb_error == 0) {

      // $fb_id = $_POST['id'];
      // $fb_accessToken = $_POST['accessToken'];
      // $fb_name = $_POST['name'];
      // $fb_email = $_POST['email'];

      $social_id = "fb_" . $fb_id;

      //ok, legit facebook login
      $account_exists = 0;
      $res = $db->sql("SELECT * FROM users WHERE social_id=? ORDER BY id DESC LIMIT 1", 's', $social_id);
      while ($row = $res->fetch_assoc()) {

        $cookie_id = $row['cookie_id'];
        $user_id = $row['id'];
        $user_email = $row['email'];
        $user_password = $row['password'];
        $login_fail = $row['login_fail'];

        $account_exists = 1;
      }

      if ($account_exists == 1) {

        if ($cookie_id == null) {
          $cookie_id = random_str(100);
        }
        $session_id = random_str(50);

        $time = $request_time;

        $db->sql("UPDATE users SET cookie_id=?, cookie_age=?, last_login=?, login_fail ='0', cookie_fail='0' WHERE id=?", 'siii', $cookie_id, $time, $time, $time);

        $db->sql("INSERT INTO active_sessions SET user_id=?, session_id=?, session_timer=?, session_type=0", 'isi', $user_id, $session_id, $time);

        $db->sql("DELETE FROM malicious_ips WHERE ip_address=?", 's', $user_ip);
        $db->sql("DELETE FROM malicious_useragents WHERE agent_ip=?", 's', $user_ip);

        setcookie("brocode_id", $user_id, $request_time + 31536000, "/");
        setcookie("brocode_session_key", $session_id, $request_time + 31536000, "/");
        setcookie("brocode_session_id", $cookie_id, $request_time + 31536000, "/");

        echo '{"response_code":"1","response_message":"SUCCESS"}';
      } else {

        include($php_base_directory . '/sections/user/new_fb_account.php');
      }
    } else {
      log_malicious();
      echo '{"response_code":"4","response_message":"ERROR"}';
    }
  }
} else {

  log_malicious();

  $location = "Location: " . $base_url;
  header($location);
  exit();

  echo '{"response_code":"4","response_message":"ERROR"}';
}
