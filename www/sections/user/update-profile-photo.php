<?php
$file_type = $_FILES['file']['type'];
$allowed = array("image/jpeg", "image/gif", "image/png");

if ($_FILES['file']['size'] / 1024 > 5120) {

  //file too large
  $return_arr = array("status" => "2", "src" => $user_avatar);
  echo json_encode($return_arr);

  exit();
} else if (!in_array($file_type, $allowed)) {

  //invalid file
  $return_arr = array("status" => "1", "src" => $user_avatar);
  echo json_encode($return_arr);

  exit();
} else {


  $phototmp_name = $_FILES['file']['tmp_name'];

  $unique_id = random_str(10);
  //$filename = "brocode-org-avatar-" . $logged_in_id;
  $filename = $unique_id;

  $imagetypes = array(
    'image/png' => '.png',
    'image/gif' => '.gif',
    'image/jpeg' => '.jpg',
    'image/bmp' => '.bmp'
  );
  $ext = $imagetypes[$_FILES['file']['type']];



  $target = $php_base_directory . "/tempfiles/";
  $src = $target . $filename . $ext;
  $src_convert = $target . $filename;
  move_uploaded_file($_FILES['file']['tmp_name'], $src);


  if ($ext == ".png") {
    //fuck PNG's, convert them
    $convertimage = imagecreatefrompng($src);
    $convertbg = imagecreatetruecolor(imagesx($convertimage), imagesy($convertimage));
    imagefill($convertbg, 0, 0, imagecolorallocate($convertbg, 255, 255, 255));
    imagealphablending($convertbg, TRUE);
    imagecopy($convertbg, $convertimage, 0, 0, 0, 0, imagesx($convertimage), imagesy($convertimage));
    imagedestroy($convertimage);
    imagejpeg($convertbg, $src_convert . ".jpg", 100);
    imagedestroy($convertbg);

    $src = $src_convert = $target . $filename . ".jpg";
    $ext = ".jpg";
  }



  $resizeObj = new resize($src);
  $resizeObj->resizeImage(336, 336, 'crop');
  $resizeObj->saveImage($src, 70);

  $return_arr = array("status" => "3", "src" => $filename . $ext);

  echo json_encode($return_arr);
}
