<?php

if ($moderation == 1) {
  $newvalue = 0;
} else {
  $newvalue = 1;
}



$mysqlquery = "UPDATE system SET value='$newvalue' WHERE name='moderation'";
$dbconn->query($mysqlquery);



echo "1";
