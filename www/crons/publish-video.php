<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include('../config/db.php');
include('../config/globals.php');


$video_to_promote = 0;
$mysqlquery="SELECT *, up_votes-down_votes as rating FROM videos WHERE status < 2 ORDER BY rating DESC LIMIT 1";
$res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
while($row=$res->fetch_assoc()) {
  $promoted_video_id = $row['id'];

  if($row['rating'] > 0){
    $video_to_promote = 1;
  } else {
    $video_to_promote = 0;
  }

}



if($video_to_promote == 1){

        $mysqlquery="SELECT * FROM videos WHERE id='$promoted_video_id' AND status > 0 ORDER BY id DESC";
        $res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
        while($row=$res->fetch_assoc()) {

          $variant_owner_id = $row['owner_id'];
          $video_imagefile = $row['thumb'];
          $owner_id = $row['owner_id'];
          $video_imagefile = str_replace($php_base_directory, $cdn_url, $video_imagefile);
          $time = time();

          $publishtimetaken = 0;
          $mysqlqueryc="SELECT * FROM videos WHERE publish_time = '$time' ORDER BY id DESC LIMIT 1";
          $resc=$dbconn->query($mysqlqueryc) or die(mysqli_error($dbconn));
          while($rowc=$resc->fetch_assoc()) {$publishtimetaken = 1;}

          if($publishtimetaken == 1){

                $mysqlqueryc="SELECT *, up_votes-down_votes as rating FROM videos WHERE status < 2 ORDER BY rating DESC LIMIT 1";
                $resc=$dbconn->query($mysqlqueryc) or die(mysqli_error($dbconn));
                while($rowc=$resc->fetch_assoc()) {
                  exit();
                }

          }else{

                $mysqlqueryz="UPDATE videos SET status='2', publish_time='$time' WHERE id='$promoted_video_id'";
                $dbconn->query($mysqlqueryz) or die(mysqli_error($dbconn));

                  //code and variant same user
                  $title="Your fellow Bros up-voted your video out of The Basement.";
                  $themessage='<div class="notificationthumbnail"><img src="' . $video_imagefile .'" class="notification_meme" /></div>';
                  $themessage=$themessage.'<div class="notificationcontent"><h2 class="notification-header">You posted a video and the other members rated it highly so we have moved it over to the main video section where it now has a permanent home (provided it stays live).</h2>';
                  $themessage=$themessage.'<p>Thanks again for posting.</p></div>';
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
