<?php

use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;

include($php_base_directory . '/functions/PHPMailer/src/Exception.php');
include($php_base_directory . '/functions/PHPMailer/src/PHPMailer.php');
include($php_base_directory . '/functions/PHPMailer/src/SMTP.php');

$emails_send = 0;

$pingCountDown = 12;
//$pingCountDown = 1;

$last_email_ping = (int)$system_data['last_email_ping'];
$total_emails_sent = (int)$system_data['email_counter'];

$sending = [];

while ($pingCountDown > 0) {

  if (time() < $last_email_ping + 5) {
    
  } else {

    $mysqlquery = "SELECT * FROM email_queue WHERE sending=0 AND attempts < 3 ORDER BY id ASC LIMIT 1";
    $res = $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
    while ($row = $res->fetch_assoc()) {

      if (!isset($sending[ $row['id'] ])) {

        echo $row['id'];


        $sending[ $row['id'] ] = 1;

        $id = $row['id'];
        $email = $row['email'];
        $display_name = $row['display_name'];
        $subject = $row['subject'];
        $body = $row['body'];
        $altbody = $row['altbody'];

        $mysqlqueryc = "UPDATE email_queue SET sending=1 WHERE id='$id'";
        $dbconn->query($mysqlqueryc) or die(mysqli_error($dbconn));

        $nowTime = time();
        $dbconn->query("UPDATE system SET value='$nowTime' WHERE name='last_email_ping'") or die(mysqli_error($dbconn));
        $last_email_ping = $nowTime;

        $total_emails_sent = $total_emails_sent + 1;
        $dbconn->query("UPDATE system SET value='$total_emails_sent' WHERE name='email_counter'") or die(mysqli_error($dbconn));

        $mail = new PHPMailer(); // create a new object
        $mail->IsSMTP(); // enable SMTP
        // $mail->SMTPOptions = array(
        //   'ssl' => array(
        //     'verify_peer' => false,
        //     'verify_peer_name' => false,
        //     'allow_self_signed' => true
        //   )
        // );
        $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true;  
        $mail->SMTPSecure = $smtp_ssltype;  
        $mail->Host = $smtp_host;
        $mail->Port = $smtp_port;
        $mail->IsHTML(true);
        $mail->Username = $smtp_username;
        $mail->Password = $smtp_password;
        $mail->SetFrom($smtp_from);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($email, $display_name);
        $mail->Timeout = 4; 

        $dbconn->query("UPDATE email_queue SET attempts=attempts+1 WHERE id='$id'");

        $sent = $mail->send(); 

        if ($sent == 1 || $sent == "1") {          
          $dbconn->query("UPDATE email_queue SET sending=2 WHERE id='$id'");
          //$mysqlqueryb = "DELETE FROM email_queue WHERE id='$id'";
        } else { 
          $dbconn->query("UPDATE email_queue SET sending=0 WHERE id='$id'");
        }

  
        $mail->ClearAddresses();
        $mail->ClearAttachments();




        $id = null;
        $email = null;
        $display_name = null;
        $subject = null;
        $body = null;
        $altbody = null;
        $mail = null;

        $emails_send = $emails_send + 1;
      }
    }
  }


  sleep(5);
  $pingCountDown = $pingCountDown - 1;
}

echo "EMAIL QUEUE COMPLETE<br />";
echo "Emails sent: " . $emails_send;
echo "<br /><br />";
