<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include('../config/db.php');
include('../config/globals.php');

$meme_to_promote = 0;
$mysqlquery="SELECT *, up_votes-down_votes as rating FROM memes WHERE status < 2 ORDER BY rating DESC LIMIT 1";
$res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
while($row=$res->fetch_assoc()) {
  $promoted_meme_id = $row['id'];

  if($row['rating'] > 0){
    $meme_to_promote = 1;
  } else {
    $meme_to_promote = 0;
  }

}


if($meme_to_promote == 1){

        $mysqlquery="SELECT * FROM memes WHERE id='$promoted_meme_id' AND status > 0 ORDER BY id DESC";
        $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
        while($row=$res->fetch_assoc()) {

          $meme_imagefile = $row['thumb'];
          $owner_id = $row['owner_id'];
          $meme_imagefile = str_replace($php_base_directory, $cdn_url, $meme_imagefile);
          $time = time();

          $publishtimetaken = 0;
          $mysqlqueryc="SELECT * FROM memes WHERE publish_time = '$time' ORDER BY id DESC LIMIT 1";
          $resc=$dbconn->query($mysqlqueryc) or die(mysqli_error($dbconn));
          while($rowc=$resc->fetch_assoc()) {$publishtimetaken = 1;}

          if($publishtimetaken == 1){
                  exit();
          }else{

                $mysqlqueryz="UPDATE memes SET status='2', publish_time='$time' WHERE id='$promoted_meme_id'";
                $dbconn->query($mysqlqueryz) or die(mysqli_error($dbconn));

                  //code and variant same user
                  $title="Your fellow Bros up-voted your Meme out of The Basement.";
                  $themessage='<div class="notificationthumbnail"><img src="' . $meme_imagefile .'" class="notification_meme" /></div>';
                  $themessage=$themessage.'<div class="notificationcontent"><h2 class="notification-header">You uploaded a Meme and the other members rated it highly so we have moved it over to the main Meme section where it now has a permanent home.</h2>';
                  $themessage=$themessage.'<p>Thanks again for your upload.</p></div>';
                  $themessage = htmlspecialchars($themessage, ENT_QUOTES);

                  $mysqlqueryz="INSERT INTO notifications SET user_id='$owner_id', title='$title', message='$themessage'";
                  $dbconn->query($mysqlqueryz) or die(mysqli_error($dbconn));

                  $mysqlqueryz="UPDATE users SET notification='1' WHERE id='$owner_id'";
                  $dbconn->query($mysqlqueryz) or die(mysqli_error($dbconn));

                  exit();

          }

        }

}
?>
