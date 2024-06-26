<?php

if ($system_data['mod_email_pinged'] == 0) {


  $mod_needed=0;


  // check code comments
  if ($mod_needed==0) {

    $mysqlquery3="SELECT id, code_id, status FROM thecode_examples WHERE status='0' ORDER BY id ASC LIMIT 1";
    $res3=$dbconn->query($mysqlquery3);
    while($row3=$res3->fetch_assoc()) {
      $code_id = $row3['code_id'];
      $mod_needed=1;

      $mysqlquery4="SELECT id FROM thecode WHERE id='$code_id' ORDER BY id ASC LIMIT 1";
      $res4=$dbconn->query($mysqlquery4);
      while($row4=$res4->fetch_assoc()) {
        $mod_needed=1;
      }
    }

  }


  // check code variant comments
  if ($mod_needed==0) {
    $mysqlquery3="SELECT id, status FROM variant_comments WHERE status='0' ORDER BY id ASC LIMIT 1";
    $res3=$dbconn->query($mysqlquery3);
    while($row3=$res3->fetch_assoc()) {
      $mod_needed=1;
    }
  }


  // check code variants
  if ($mod_needed==0) {
    $mysqlquery3="SELECT id, status FROM underground_codevariants WHERE status<'2' ORDER BY id ASC LIMIT 1";
    $res3=$dbconn->query($mysqlquery3);
    while($row3=$res3->fetch_assoc()) {
      $mod_needed=1;
    }
  }


  // check new topics
  if ($mod_needed==0) {
    $mysqlquery3="SELECT id, status FROM topics WHERE status='0' ORDER BY id ASC LIMIT 1";
    $res3=$dbconn->query($mysqlquery3);
    while($row3=$res3->fetch_assoc()) {
      $mod_needed=1;
    }
  }


  // check new topics
  if ($mod_needed==0) {
    $mysqlquery3="SELECT id, status FROM topics WHERE status='0' ORDER BY id ASC LIMIT 1";
    $res3=$dbconn->query($mysqlquery3);
    while($row3=$res3->fetch_assoc()) {
      $mod_needed=1;
    }
  }


  // check new topics
  if ($mod_needed==0) {
    $mysqlquery3="SELECT id, topic_id, status FROM topic_replies WHERE status='0' ORDER BY id ASC LIMIT 1";
    $res3=$dbconn->query($mysqlquery3);
    while($row3=$res3->fetch_assoc()) {
      $topic_id = $row3['topic_id'];
      $mod_needed=1;

      $mysqlquery4="SELECT id, status FROM topics WHERE id='$topic_id' ORDER BY id ASC LIMIT 1";
      $res4=$dbconn->query($mysqlquery4);
      while($row4=$res4->fetch_assoc()) {
        $mod_needed=1;
      }
    }
  }







  if ($mod_needed == 1) {


    $themessage='<table width="300" style="display:block; width:300px; border:none; margin:20px auto; border-collapse:collapse;"><tr><th>';
    $themessage=$themessage .'<img src="'. $smtp_logo .'" style="width:239px; display:block; margin:30px auto 30px auto;" />';
    $themessage=$themessage .'<h1 style="color:#0066a3; font-weight:bold; font-size:16pt; display:block; width:80%; text-align:center; padding:0 10% 0 10%; margin:0 0 20px 0;">BRO CODE HAS STUFF TO MODERATE</h1>';
    $themessage=$themessage .'</th></tr></table>';

    $altbody='BRO CODE HAS STUFF TO MODERATE';

    $mysqlquery="INSERT INTO email_queue SET
    email='kookynetwork@protonmail.com',
    display_name = 'The Bro Code',
    subject='BRO CODE HAS STUFF TO MODERATE',
    body='$themessage',
    altbody='$altbody'";
    $dbconn->query($mysqlquery);

    $db->sql( "UPDATE system SET value='1' WHERE name=?", 's' , 'mod_email_pinged' );

  }




}













 ?>
