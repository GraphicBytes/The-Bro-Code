<?php

$last_temp_files_clean=$system_data['last_temp_files_clean'];

if (($request_time - $last_temp_files_clean) > 1800) {

  $time=time();
  $time=$time-( 60 * 60 );

  $path = $php_base_directory . '/tempfiles/';

          // Open the directory
          if ($handle = opendir($path))
          {
              // Loop through the directory
              while (false !== ($file = readdir($handle)))
              {
                  // Check the file we're doing is actually a file
                  if (is_file($path.$file))
                  {
                      // Check if the file is older than X days old
                      if (filemtime($path.$file) < ( time() - ( 60 * 60 ) ) )
                      {
                          $fileext = substr(strrchr($file,'.'),1);

                          if ($fileext == "php"){}else {
                          unlink($path.$file);
                          }
                      }
                  }
              }
          }

  $mysqlquery="UPDATE system SET value='$request_time' WHERE name='last_temp_files_clean'";
  $dbconn->query($mysqlquery) or die(mysqli_error($dbconn));

  echo "DELETED OLD TEMP FILES";
  echo "<br />";

}else{

  echo "TEMP FILE CLEAN ON TIMEOUT";
  echo "<br />";

}




?>
