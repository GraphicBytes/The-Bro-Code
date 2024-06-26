<?php
function login_check(){

  global $db;
  global $base_url;
  global $user_ip;
  global $request_time;

  $login_details=array();


  $loginphase = 0;
  $login_banned = 0;

  $id = null;
  $cookie_id = null;
  $cookie_fail = null;
  $login_fail = null;

  //are cookies set
  if (isset($_COOKIE["brocode_id"])){
    $brocode_id = $_COOKIE['brocode_id'];
    $loginphase = $loginphase + 1;
  }
  if (isset($_COOKIE["brocode_session_id"])){
    $brocode_session_id = $_COOKIE['brocode_session_id'];
    $loginphase = $loginphase + 1;
  }
  if (isset($_COOKIE["brocode_session_key"])){
    $brocode_session_key = $_COOKIE['brocode_session_key'];
    $loginphase = $loginphase + 1;
  }


  if (is_malicious()) {

    log_malicious();

    setcookie('brocode_id', null, -1, '/');
    setcookie('brocode_session_id', null, -1, '/');
    setcookie('brocode_session_key', null, -1, '/');
    unset($_COOKIE['brocode_id']);
    unset($_COOKIE['brocode_session_id']);
    unset($_COOKIE['brocode_session_key']);

    $login_details['id'] = 0;
    $loginphase = 0;
  }


  if ($loginphase == 3) {

    $res=$db->sql( "SELECT * FROM users WHERE id=?", 'i' , $brocode_id );
    while($row=$res->fetch_assoc()) {

      $id = $row['id'];
      $useremail = $row['email'];
      $cookie_id = $row['cookie_id'];
      $cookie_fail = $row['cookie_fail'];
      $login_fail = $row['login_fail'];
      $login_warnings = $row['warnings'];
      $login_banned = $row['banned'];

      $email_verfied = $row['email_verfied'];
      $notification = $row['notification'];
      $tandc_seen = $row['tandc_seen'];
      $view_order = $row['view_order'];
      $hide_shit = $row['hide_shit'];
      $account_type = $row['account_type'];

      $update_profile = $row['update_profile'];

      $user_display_name = $row['display_name'];
      $user_email = $row['email'];
      $user_bio = $row['bio'];

      $user_facebook = $row['facebook_url'];
      $user_twitter = $row['twitter'];
      $user_website = $row['website_url'];

      $user_avatar = $row['avatar'];
      $avatar_mini = $row['avatar_mini'];

      }



          //active key check
          $session_key_check = 0;
          $keyres=$db->sql( "SELECT * FROM active_sessions WHERE user_id=? AND session_id=?", 'is' , $id, $brocode_session_key );
          while($keyrow=$keyres->fetch_assoc()) {
            $session_id = $keyrow['id'];
            $session_timer = $keyrow['session_timer'];
            $session_type = $keyrow['session_type'];

            if ($session_type == 1) {
              $session_age_limit = 604800;
            } else {
              $session_age_limit = 600;
            }

            if (($request_time - $session_age_limit) < $session_timer) {
              $session_key_check = 1;
            }
          }



              if ($brocode_session_id == $cookie_id && $cookie_fail < 10 && $login_fail < 10 && $login_banned == 0 && $session_key_check==1){

                if ($cookie_fail > 0) {
                  $res=$db->sql( "UPDATE users SET cookie_fail = 0, last_login=? WHERE id = ?", 'ii' , $request_time, $brocode_id );
                } else {
                  $res=$db->sql( "UPDATE users SET last_login=? WHERE id =?", 'ii' , $request_time, $brocode_id );
                }

                $db->sql( "UPDATE active_sessions SET session_timer=? WHERE id=?", 'ii' , $request_time, $session_id );

                //looks good, carry on
                $login_details['id'] = $id;

                $login_details['email_verfied'] = $email_verfied;
                $login_details['notification'] = $notification;
                $login_details['tandc_seen'] = $tandc_seen;
                $login_details['view_order'] = $view_order;
                $login_details['hide_shit'] = $hide_shit;
                $login_details['account_type'] = $account_type;

                $login_details['user_display_name'] = $user_display_name;
                $login_details['user_email'] = $user_email;
                $login_details['user_bio'] = $user_bio;

                $login_details['user_facebook'] = $user_facebook;
                $login_details['user_twitter'] = $user_twitter;
                $login_details['user_website'] = $user_website;

                $login_details['user_avatar'] = $user_avatar;
                $login_details['user_avatar_mini'] = $avatar_mini;

                $login_details['session_id'] = $session_id;

                $login_details['update_profile'] = $update_profile;

              }else if($login_banned == 1){

                $login_details['id'] = -1;

              }else if($cookie_fail > 10 or $login_fail > 10){

                $db->sql( "UPDATE users SET cookie_fail = cookie_fail + 1 WHERE id = ?", 'i' , $brocode_id );
                $login_details['id'] = 0;

                log_malicious();

                //Cookie missmatch or brute force attach, unset to spare DB load
                setcookie('brocode_id', null, -1, '/');
                setcookie('brocode_session_id', null, -1, '/');
                setcookie('brocode_session_key', null, -1, '/');
                unset($_COOKIE['brocode_id']);
                unset($_COOKIE['brocode_session_id']);
                unset($_COOKIE['brocode_session_key']);
                $login_details['id'] = 0;

              }else{

                //Missmatch, log to prevent brute force attack
                $db->sql( "UPDATE users SET cookie_fail = cookie_fail + 1 WHERE id = ?", 'i' , $brocode_id );
                $login_details['id'] = 0;

                log_malicious();

                //Cookie missmatch or brute force attach, unset to spare DB load
                setcookie('brocode_id', null, -1, '/');
                setcookie('brocode_session_id', null, -1, '/');
                setcookie('brocode_session_key', null, -1, '/');
                unset($_COOKIE['brocode_id']);
                unset($_COOKIE['brocode_session_id']);
                unset($_COOKIE['brocode_session_key']);
                $login_details['id'] = 0;

              }

  } else {

  //cookie error, move on
  $login_details['id'] = 0;

  }

return $login_details;

}
?>
