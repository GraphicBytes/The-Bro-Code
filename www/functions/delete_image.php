<?php

function delete_image($image_id){

  global $dbconn;
  global $php_base_directory;
  $deleted=0;

  $sql="SELECT * FROM uploads WHERE id='$image_id' ORDER BY id ASC";
  $res=$dbconn->query($sql) or die(mysqli_error($dbconn));
  while($row=$res->fetch_assoc()) {

    $imagefile = $php_base_directory . $row['imagefile'];
    $thumb = $php_base_directory . $row['thumb'];

    if (file_exists($imagefile)) {unlink($imagefile);}
    if (file_exists($thumb)) {unlink($thumb);}

    $deleted=1;
  }

  return $deleted;
}






























//
