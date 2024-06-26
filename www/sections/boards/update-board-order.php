<?php
 $parent = $typea;
 $the_order = $_POST['the_order'];

 $order=0;

 foreach ($the_order as $value) {

   $mysqlquery="UPDATE boards SET post_order='$order' WHERE id='$value'";
   $res=$dbconn->query($mysqlquery);

   $order=$order+1;
 }


?>
