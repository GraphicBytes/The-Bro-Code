<?php

$return_arr = array();
$name_taken = 0;
$email_taken = 0;
$bio_updated = 0;


// check Username
$submitted_display_name = htmlspecialchars($_POST['display_name'], ENT_QUOTES);
if ($user_display_name != $submitted_display_name) {

  $display_name_query = "SELECT display_name FROM users WHERE display_name='$submitted_display_name' ORDER BY id DESC LIMIT 1";
  $res = $dbconn->query($display_name_query);
  while ($row = $res->fetch_assoc()) {
    $name_taken = 1;
  }

  if ($name_taken == 0) {
    $update_display_name_query = "UPDATE users SET display_name='$submitted_display_name' WHERE id='$logged_in_id'";
    $dbconn->query($update_display_name_query);
    $return_arr['display_name'] = $submitted_display_name;
    $return_arr['name_updated'] = 1;
    $return_arr['name_taken'] = 0;
  } else {
    $return_arr['display_name'] = $user_display_name;
    $return_arr['name_updated'] = 0;
    $return_arr['name_taken'] = 1;
  }
  //dazwtf

} else {
  $return_arr['display_name'] = $user_display_name;
  $return_arr['name_updated'] = 0;
  $return_arr['name_taken'] = 0;
}






// check email
$submitted_email = $_POST['email'];

if (filter_var($submitted_email, FILTER_VALIDATE_EMAIL)) {
  $email_valid = 1;
} else {
  $email_valid = 0;
}
$return_arr['email_valid'] = $email_valid;


if ($user_email != $submitted_email && $email_valid == 1) {

  $res = $db->sql("SELECT email FROM users WHERE email=? ORDER BY id DESC LIMIT 1", 's', $submitted_email);
  while ($row = $res->fetch_assoc()) {
    $email_taken = 1;
  }

  if ($email_taken == 0) {

    $email_validation_code = random_str(50);
    $time = time();

    $db->sql("UPDATE users SET email=?, email_verfied='0', email_validation_code=?, validation_age=? WHERE id=?", 'ssii', $id);
    $return_arr['email'] = $submitted_email;
    $return_arr['email_updated'] = 1;
    $return_arr['email_taken'] = 0;
  } else {
    $return_arr['email'] = $user_email;
    $return_arr['email_updated'] = 0;
    $return_arr['email_taken'] = 1;
  }
  //dazwtf

} else {
  $return_arr['email'] = $user_email;
  $return_arr['email_updated'] = 0;
  $return_arr['email_taken'] = 0;
}






// check bio
$submitted_bio = htmlspecialchars($_POST['bio'], ENT_QUOTES);
$bio_length_warning = 0;
if ($user_bio != $submitted_bio) {

  $bio_length = strlen($submitted_bio);
  $return_arr['bio_length'] = $bio_length;

  if ($bio_length < 250) {
    $db->sql("UPDATE users SET bio=? WHERE id=?", 'si', $submitted_bio, $logged_in_id);
    $return_arr['bioupdated'] = 1;
    $return_arr['biotoolong'] = 0;
  } else {
    $bio_length_warning = 1;
    $return_arr['bioupdated'] = 0;
    $return_arr['biotoolong'] = 1;
  }
} else {
  $return_arr['bioupdated'] = 0;
  $return_arr['biotoolong'] = 0;
}








// check password
$passworda = $_POST['password'];
$passwordb = $_POST['passwordb'];
$pwerror = 0;

if ($passworda != "") {

  if ($passworda == $passwordb) {
    $pw_length = strlen($passworda);

    if ($pw_length > 5) {

      $newpassword = hash('sha256', $passwordb . $websitesalt);
      $res = $db->sql("UPDATE users SET password=? WHERE id=?", 'si', $newpassword, $logged_in_id);

      $pwerror = 0;
      $return_arr['passwordupdated'] = 1;
      $return_arr['passwordtooshort'] = 0;
      $return_arr['passwordmissmatch'] = 0;
    } else {
      $pwerror = 1;
      $return_arr['passwordupdated'] = 0;
      $return_arr['passwordtooshort'] = 1;
      $return_arr['passwordmissmatch'] = 0;
    }
  } else {
    $pwerror = 1;
    $return_arr['passwordupdated'] = 0;
    $return_arr['passwordtooshort'] = 0;
    $return_arr['passwordmissmatch'] = 1;
  }
} else {
  $pwerror = 0;
  $return_arr['passwordupdated'] = 0;
  $return_arr['passwordtooshort'] = 0;
  $return_arr['passwordmissmatch'] = 0;
}






// NEW FILE
$newfile = $_POST['newfileprofile'];
if ($newfile != 1) {

  $filename_rnd = random_str(10);

  $ext = pathinfo($newfile, PATHINFO_EXTENSION);

  $folder = ceil($logged_in_id / 100);
  $permanant_home = $folder;
  $permanant_home_raw = $php_base_directory . "/avatars/" . $folder . "/";

  $location = $permanant_home . "/tbc-avatar-" . $logged_in_id . $filename_rnd . "." . $ext;
  $locationmini = $permanant_home . "/tbc-avatar-mini-" . $logged_in_id . $filename_rnd . "." . $ext;

  $real_location = $php_base_directory . "/tempfiles/" . $newfile;
  $real_target = $php_base_directory . "/avatars/" . $location;
  $real_target_mini = $php_base_directory . "/avatars/" . $locationmini;


  if (!file_exists($permanant_home_raw)) {
    mkdir($permanant_home_raw, 0777, true);
  }

  $resizeObj = new resize($real_location);
  $resizeObj->resizeImage(50, 50, 'crop');
  $resizeObj->saveImage($real_target_mini, 70);

  copy($real_location, $real_target);

  if ($user_avatar != "default.jpg") {
    if (file_exists($php_base_directory . "/avatars/" . $user_avatar)) {
      unlink($php_base_directory . "/avatars/" . $user_avatar);
    }
    if (file_exists($php_base_directory . "/avatars/" . $avatar_mini)) {
      unlink($php_base_directory . "/avatars/" . $avatar_mini);
    }
  }

  $db->sql("UPDATE users SET avatar=?,  avatar_mini=? WHERE id=?", 'ssi', $location, $locationmini, $logged_in_id);
  $return_arr['avatarupdated'] = 1;
} else {
  $return_arr['avatarupdated'] = 0;
}






if ($name_taken == '1' or  $email_taken == '1' or $email_valid == '0' or $bio_length_warning == '1' or $pwerror == '1') {
  $return_arr['status'] = '2';
} else {
  $return_arr['status'] = '1';
}

echo json_encode($return_arr);
