<?php
  $return_arr = array();
  $membersonly=0;

//##########################################################
//####################   topic header   ####################
//##########################################################

    $newtopicheader = $_POST['newtopicheader'];
    $newtopicheader_length = strlen($newtopicheader);

    // is topic header too short
    if ($newtopicheader_length < 6) {
      $return_arr['response'] = 0;
    } else {
      $return_arr['response'] = 1;


      $newtopicheader = $dbconn->real_escape_string($newtopicheader);
      $newtopicheader = substr($newtopicheader,0,300);

      $topic_slug = create_slug($newtopicheader);

      $mysqlquery3="SELECT id, slug FROM topics WHERE slug='$topic_slug' ORDER BY id DESC";
      $res3=$dbconn->query($mysqlquery3);
      while($row3=$res3->fetch_assoc()) {
        $topic_slug = $topic_slug . random_str(10);
      }

      $return_arr['topic_slug'] = $topic_slug;
      $unique_id = random_str(250);
      $post_time = time();
      $last_update_time = $post_time;
    }

    $insert_query_current = "INSERT INTO topics SET
      owner_id='$logged_in_id', board_id='$typea', title='$newtopicheader', slug='$topic_slug', owner_ip='$user_ip', post_time='$post_time', last_update_time='$last_update_time', unique_id='$unique_id'";



//###################################################
//####################   video   ####################
//###################################################

    $newtopicvideo = $_POST['video'];

    if ($newtopicvideo == 1) {
      $video_type = $_POST['video_type'];
      $video_id = $_POST['video_id'];

      $video_type = $dbconn->real_escape_string($video_type);
      $video_id = $dbconn->real_escape_string($video_id);

      $video_id = substr($video_id,0,500);

      if ($video_type == 'youtube' or $video_type == 'vimeo') {

        if ($video_type == 'youtube') {
          $video=1;
        } else if ($video_type == 'vimeo'){
          $video=2;
        } else {
          $video=0;
        }

        if ($video_id != null or $video_id !="") {
          $insert_query_current = $insert_query_current . ", video='$video', video_id='$video_id'";
        }
      }
    }





//###########################################################
//####################   image gallery   ####################
//###########################################################

    $imagegallery = $_POST['imagegallery'];
    $unique_path = random_str(10);
    $post_time = time();

    function insert_image($id,$type,$unique_path){

      global $logged_in_id;
      global $php_base_directory;
      global $dbconn;
      global $post_time;

      $image = $php_base_directory . '/tempfiles/' . $id . $type;
      $image_thumb = $php_base_directory . '/tempfiles/' . $id . '_thumb'. $type;

      $permanant_home=$php_base_directory."/uploads/" . $logged_in_id . "/"  . date("Y"). "/" . date("m"). "/" . date("d"). "/" . $unique_path . "/" ;

      //Create Directory
      if (!file_exists($permanant_home)) {
        mkdir($permanant_home, 0777, true);
      }

      $filename = "brocode-org-" . random_str(10);
      $filename_thumb = "brocode-org-" . random_str(10) . "_thumb";

      $target = $permanant_home . $filename .$type;
      $target_thumb = $permanant_home . $filename_thumb .$type;

      $target_relative = "/uploads/" . $logged_in_id . "/"  . date("Y"). "/" . date("m"). "/" . date("d"). "/" . $unique_path . "/" . $filename .$type;
      $target_thumb_relative = "/uploads/" . $logged_in_id . "/"  . date("Y"). "/" . date("m"). "/" . date("d"). "/" . $unique_path . "/" . $filename_thumb .$type;

      copy($image, $target);
      copy($image_thumb, $target_thumb);

      list($imgwidth, $imgheight) = getimagesize($target);


      $insert_query="INSERT INTO uploads SET post_time='$post_time', imagefile='$target_relative', thumb='$target_thumb_relative', img_width='$imgwidth', img_height='$imgheight', owner_id='$logged_in_id'";
      $dbconn->query($insert_query);

      $mysqlquery="SELECT * FROM uploads WHERE imagefile='$target_relative' ORDER BY id ASC LIMIT 1";
      $res=$dbconn->query($mysqlquery);
      while($row=$res->fetch_assoc()) {
        $new_id = $row['id'];
      }

      return $new_id;

    }

    if ($imagegallery == 1) {

      $thegallery=array();

      $gallery_wrong = 0;
      if (isset($_POST['gallery_item_1'])) {
        $gallery_item = $_POST['gallery_item_1'];
        $gallery_item_type_name = $_POST['gallery_item_type_name_1'];
        $thegallery['gallery_item_1'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
      } else {$gallery_wrong = 1;}

      if ($gallery_wrong == 0) {

        if (isset($_POST['gallery_item_2'])) {
          $gallery_item = $_POST['gallery_item_2'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_2'];
          $thegallery['gallery_item_2'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_3'])) {
          $gallery_item = $_POST['gallery_item_3'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_3'];
          $thegallery['gallery_item_3'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_4'])) {
          $gallery_item = $_POST['gallery_item_4'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_4'];
          $thegallery['gallery_item_4'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_5'])) {
          $gallery_item = $_POST['gallery_item_5'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_5'];
          $thegallery['gallery_item_5'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_6'])) {
          $gallery_item = $_POST['gallery_item_6'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_6'];
          $thegallery['gallery_item_6'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_7'])) {
          $gallery_item = $_POST['gallery_item_7'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_7'];
          $thegallery['gallery_item_7'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_8'])) {
          $gallery_item = $_POST['gallery_item_8'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_8'];
          $thegallery['gallery_item_8'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_9'])) {
          $gallery_item = $_POST['gallery_item_9'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_9'];
          $thegallery['gallery_item_9'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_10'])) {
          $gallery_item = $_POST['gallery_item_10'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_10'];
          $thegallery['gallery_item_10'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_11'])) {
          $gallery_item = $_POST['gallery_item_11'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_11'];
          $thegallery['gallery_item_11'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_12'])) {
          $gallery_item = $_POST['gallery_item_12'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_12'];
          $thegallery['gallery_item_12'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_13'])) {
          $gallery_item = $_POST['gallery_item_13'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_13'];
          $thegallery['gallery_item_13'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_14'])) {
          $gallery_item = $_POST['gallery_item_14'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_14'];
          $thegallery['gallery_item_14'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_15'])) {
          $gallery_item = $_POST['gallery_item_15'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_15'];
          $thegallery['gallery_item_15'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_16'])) {
          $gallery_item = $_POST['gallery_item_16'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_16'];
          $thegallery['gallery_item_16'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_17'])) {
          $gallery_item = $_POST['gallery_item_17'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_17'];
          $thegallery['gallery_item_17'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_18'])) {
          $gallery_item = $_POST['gallery_item_18'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_18'];
          $thegallery['gallery_item_18'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_19'])) {
          $gallery_item_19 = $_POST['gallery_item_19'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_19'];
          $thegallery['gallery_item_19'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_20'])) {
          $gallery_item = $_POST['gallery_item_20'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_19'];
          $thegallery['gallery_item_20'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_21'])) {
          $gallery_item = $_POST['gallery_item_21'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_20'];
          $thegallery['gallery_item_21'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_22'])) {
          $gallery_item = $_POST['gallery_item_22'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_21'];
          $thegallery['gallery_item_22'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_23'])) {
          $gallery_item = $_POST['gallery_item_23'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_23'];
          $thegallery['gallery_item_23'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_24'])) {
          $gallery_item = $_POST['gallery_item_24'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_24'];
          $thegallery['gallery_item_24'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_25'])) {
          $gallery_item = $_POST['gallery_item_25'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_25'];
          $thegallery['gallery_item_25'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_26'])) {
          $gallery_item = $_POST['gallery_item_26'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_26'];
          $thegallery['gallery_item_26'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_27'])) {
          $gallery_item = $_POST['gallery_item_27'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_27'];
          $thegallery['gallery_item_27'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_28'])) {
          $gallery_item = $_POST['gallery_item_28'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_28'];
          $thegallery['gallery_item_28'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_29'])) {
          $gallery_item = $_POST['gallery_item_29'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_29'];
          $thegallery['gallery_item_29'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_30'])) {
          $gallery_item = $_POST['gallery_item_30'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_30'];
          $thegallery['gallery_item_30'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_31'])) {
          $gallery_item = $_POST['gallery_item_31'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_31'];
          $thegallery['gallery_item_31'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
        if (isset($_POST['gallery_item_31'])) {
          $gallery_item = $_POST['gallery_item_31'];
          $gallery_item_type_name = $_POST['gallery_item_type_name_31'];
          $thegallery['gallery_item_31'] = insert_image($gallery_item, $gallery_item_type_name, $unique_path);
        }
      }

      if ($gallery_wrong == 1) {
        $insert_query_current = $insert_query_current . ", gallery='0'";
      } else{
        $gallery_ids = serialize($thegallery);
        $insert_query_current = $insert_query_current . ", gallery='1', gallery_ids='$gallery_ids'";
      }
    }



//#####################################################
//####################   content   ####################
//#####################################################

    if (isset($_POST['new_topic_content'])) {
      $new_topic_content = $_POST['new_topic_content'];

      if ($new_topic_content != null && $new_topic_content != "") {
        $new_topic_content = $dbconn->real_escape_string($new_topic_content);
        $new_topic_content = substr($new_topic_content,0,10000);

        $insert_query_current = $insert_query_current . ", content='$new_topic_content'";

      }
    }



//##################################################
//####################   poll   ####################
//##################################################

    $poll = $_POST['poll'];

    if ($poll == 1) {

      $thepoll=array();
      $poll_wrong = 0;

      if (isset($_POST['poll_option_1'])) { if ($_POST['poll_option_1'] != ""){
        $poll_option_1 = $_POST['poll_option_1'];
        $thepoll['poll_option_1'] = $dbconn->real_escape_string($poll_option_1);
      }} else {$poll_wrong = 1;}

      if (isset($_POST['poll_option_2'])) { if ($_POST['poll_option_2'] != ""){
        $poll_option_2 = $_POST['poll_option_2'];
        $thepoll['poll_option_2'] = $dbconn->real_escape_string($poll_option_2);
      }} else {$poll_wrong = 1;}

      if ($poll_wrong == 0) {

        if (isset($_POST['poll_option_3'])) { if ($_POST['poll_option_3'] != ""){
          $poll_option_3 = $_POST['poll_option_3'];
          $thepoll['poll_option_3'] = $dbconn->real_escape_string($poll_option_3);
        }}
        if (isset($_POST['poll_option_4'])) { if ($_POST['poll_option_4'] != ""){
          $poll_option_4 = $_POST['poll_option_4'];
          $thepoll['poll_option_4'] = $dbconn->real_escape_string($poll_option_4);
        }}
        if (isset($_POST['poll_option_5'])) { if ($_POST['poll_option_5'] != ""){
          $poll_option_5 = $_POST['poll_option_5'];
          $thepoll['poll_option_5'] = $dbconn->real_escape_string($poll_option_5);
        }}
        if (isset($_POST['poll_option_6'])) { if ($_POST['poll_option_6'] != ""){
          $poll_option_6 = $_POST['poll_option_6'];
          $thepoll['poll_option_6'] = $dbconn->real_escape_string($poll_option_6);
        }}
        if (isset($_POST['poll_option_7'])) { if ($_POST['poll_option_7'] != ""){
          $poll_option_7 = $_POST['poll_option_7'];
          $thepoll['poll_option_7'] = $dbconn->real_escape_string($poll_option_7);
        }}
        if (isset($_POST['poll_option_8'])) { if ($_POST['poll_option_8'] != ""){
          $poll_option_8 = $_POST['poll_option_8'];
          $thepoll['poll_option_8'] = $dbconn->real_escape_string($poll_option_8);
        }}
        if (isset($_POST['poll_option_9'])) { if ($_POST['poll_option_9'] != ""){
          $poll_option_9 = $_POST['poll_option_9'];
          $thepoll['poll_option_9'] = $dbconn->real_escape_string($poll_option_9);
        }}
        if (isset($_POST['poll_option_10'])) { if ($_POST['poll_option_10'] != ""){
          $poll_option_10 = $_POST['poll_option_10'];
          $thepoll['poll_option_10'] = $dbconn->real_escape_string($poll_option_10);
        }}
        if (isset($_POST['poll_option_11'])) { if ($_POST['poll_option_11'] != ""){
          $poll_option_11 = $_POST['poll_option_11'];
          $thepoll['poll_option_11'] = $dbconn->real_escape_string($poll_option_11);
        }}
        if (isset($_POST['poll_option_12'])) { if ($_POST['poll_option_12'] != ""){
          $poll_option_12 = $_POST['poll_option_12'];
          $thepoll['poll_option_12'] = $dbconn->real_escape_string($poll_option_12);
        }}
        if (isset($_POST['poll_option_13'])) { if ($_POST['poll_option_13'] != ""){
          $poll_option_13 = $_POST['poll_option_13'];
          $thepoll['poll_option_13'] = $dbconn->real_escape_string($poll_option_13);
        }}
        if (isset($_POST['poll_option_14'])) { if ($_POST['poll_option_14'] != ""){
          $poll_option_14 = $_POST['poll_option_14'];
          $thepoll['poll_option_14'] = $dbconn->real_escape_string($poll_option_14);
        }}
        if (isset($_POST['poll_option_15'])) { if ($_POST['poll_option_15'] != ""){
          $poll_option_15 = $_POST['poll_option_15'];
          $thepoll['poll_option_15'] = $dbconn->real_escape_string($poll_option_15);
        }}
        if (isset($_POST['poll_option_16'])) { if ($_POST['poll_option_16'] != ""){
          $poll_option_16 = $_POST['poll_option_16'];
          $thepoll['poll_option_16'] = $dbconn->real_escape_string($poll_option_16);
        }}
        if (isset($_POST['poll_option_17'])) { if ($_POST['poll_option_17'] != ""){
          $poll_option_17 = $_POST['poll_option_17'];
          $thepoll['poll_option_17'] = $dbconn->real_escape_string($poll_option_17);
        }}
        if (isset($_POST['poll_option_18'])) { if ($_POST['poll_option_18'] != ""){
          $poll_option_18 = $_POST['poll_option_18'];
          $thepoll['poll_option_18'] = $dbconn->real_escape_string($poll_option_18);
        }}
        if (isset($_POST['poll_option_19'])) { if ($_POST['poll_option_19'] != ""){
          $poll_option_19 = $_POST['poll_option_19'];
          $thepoll['poll_option_19'] = $dbconn->real_escape_string($poll_option_19);
        }}
        if (isset($_POST['poll_option_20'])) { if ($_POST['poll_option_20'] != ""){
          $poll_option_20 = $_POST['poll_option_20'];
          $thepoll['poll_option_20'] = $dbconn->real_escape_string($poll_option_20);
        }}
      }

      if ($poll_wrong == 1) {
        $insert_query_current = $insert_query_current . ", poll='0'";
      } else {
        $poll_choices = serialize($thepoll);
        $insert_query_current = $insert_query_current . ", poll='1', poll_choices='$poll_choices'";
      }

    } else {
      $insert_query_current = $insert_query_current . ", poll='0'";
    }



//###################################################
//####################   links   ####################
//###################################################

    $links = $_POST['links'];

    if ($links == 1) {

      $membersonly=1;

      $thelinks=array();
      $links_wrong = 0;

      if (isset($_POST['link_1'])) { if ($_POST['link_1'] != ""){
        $link_1 = $_POST['link_1'];
        $link_1 = filter_var($link_1, FILTER_SANITIZE_URL);
        if (filter_var($link_1, FILTER_VALIDATE_URL) !== false) {
          $thelinks['link_1'] = $dbconn->real_escape_string($link_1);
        }
      }} else {$links_wrong = 1;}



      if ($links_wrong == 0) {

        if (isset($_POST['link_2'])) { if ($_POST['link_2'] != ""){
          $link_2 = $_POST['link_2'];
          $link_2 = filter_var($link_2, FILTER_SANITIZE_URL);
          if (filter_var($link_2, FILTER_VALIDATE_URL) !== false) {
            $thelinks['link_2'] = $dbconn->real_escape_string($link_2);
          }
        }}
        if (isset($_POST['link_3'])) { if ($_POST['link_3'] != ""){
          $link_3 = $_POST['link_3'];
          $link_3 = filter_var($link_3, FILTER_SANITIZE_URL);
          if (filter_var($link_3, FILTER_VALIDATE_URL) !== false) {
            $thelinks['link_3'] = $dbconn->real_escape_string($link_3);
          }
        }}
        if (isset($_POST['link_4'])) { if ($_POST['link_4'] != ""){
          $link_4 = $_POST['link_4'];
          $link_4 = filter_var($link_4, FILTER_SANITIZE_URL);
          if (filter_var($link_4, FILTER_VALIDATE_URL) !== false) {
            $thelinks['link_4'] = $dbconn->real_escape_string($link_4);
          }
        }}
        if (isset($_POST['link_5'])) { if ($_POST['link_5'] != ""){
          $link_5 = $_POST['link_5'];
          $link_5 = filter_var($link_5, FILTER_SANITIZE_URL);
          if (filter_var($link_5, FILTER_VALIDATE_URL) !== false) {
            $thelinks['link_5'] = $dbconn->real_escape_string($link_5);
          }
        }}

        if ($poll_wrong == 1) {
          $insert_query_current = $insert_query_current . ", links='0'";
        } else{
          $link_urls = serialize($thelinks);
          $insert_query_current = $insert_query_current . ", links='1', link_urls='$link_urls'";
        }

      } else {
        $insert_query_current = $insert_query_current . ", links='0'";
      }
    }




//##########################################################
//####################   members only   ####################
//##########################################################

  if ($membersonly == 0) {
    $membersonly = $_POST['membersonly'];
  }
  $insert_query_current = $insert_query_current . ", members_only='$membersonly'";


  $dbconn->query($insert_query_current);


$return_arr = array("response" => 1, "slug"=> $topic_slug);
echo json_encode($return_arr);
