<?php
$allowed = array("image/jpeg", "image/gif", "image/png");
$return_arr=array();

$totaluploads = count($_FILES['file']['name']);

$image_count=0;
if ($totaluploads < 33 ) {

  for( $i=0 ; $i < $totaluploads ; $i++ ) {
    if($_FILES['file']['size'][$i] / 1024 < 5120){

      $file_type = $_FILES['file']['type'][$i];
      if(in_array($file_type, $allowed)) {

        $gallery_item=array();

        $phototmp_name = $_FILES['file']['tmp_name'][$i];
        $unique_id = random_str(100);
        $filename = $unique_id;
        $imagetypes = array(
            'image/png' => '.png',
            'image/gif' => '.gif',
            'image/jpeg' => '.jpg',
            'image/bmp' => '.bmp');
        $ext = $imagetypes[$_FILES['file']['type'][$i]];

        $target = $php_base_directory."/tempfiles/";
        $src = "tempfiles/" . $filename .$ext;
        $src_thumb = "tempfiles/" . $filename . "_thumb" .$ext;
        $font_src_thumb = "" . $filename . "_thumb" .$ext;
        $target = $target . $filename .$ext;
        move_uploaded_file($_FILES['file']['tmp_name'][$i], $src);

        $resizeObj = new resize($src);
        $resizeObj -> resizeImage(336, 336, 'crop');
        $resizeObj -> saveImage($src_thumb, 70);

        $image_id = "image_" . $image_count;

        $gallery_item['url']=$src;
        $gallery_item['thumb']=$font_src_thumb;
        $gallery_item['id']=$filename;
        $gallery_item['type']=$ext;

        $return_arr[$image_id] = $gallery_item;

        $image_count=$image_count+1;
      }
    }
  }

}

echo json_encode($return_arr);

?>
