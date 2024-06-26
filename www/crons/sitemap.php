<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include('../config/db.php');
include('../config/globals.php');




ob_start();
?><?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">
<?php

$mysqlquery="SELECT * FROM thecode ORDER BY id DESC";
$res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
while($row=$res->fetch_assoc()) {

  $id = $row['id'];
  $slug = $row['slug'];
  $loc = $base_url . "/code/" . $slug . "/";
  $lastmod = $row['publish_time'];
  $lastmod = gmdate('Y-m-d', $lastmod);

?>
<url><loc><?php echo $loc; ?></loc><lastmod><?php echo $lastmod; ?></lastmod><changefreq>monthly</changefreq><priority>0.8</priority></url>
<?php } ?></urlset>
<?php
$string = ob_get_clean();
$sitemapfile = $php_base_directory . "/code_sitemap.xml";
$fp = fopen($sitemapfile, "w+");
fwrite($fp, $string);
fclose($fp);






ob_start();
?><?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">
<?php

$mysqlquery="SELECT * FROM memes WHERE status = '2' AND sfw > '0' ORDER BY publish_time DESC";
$res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
while($row=$res->fetch_assoc()) {

  $id = $row['id'];
  $slug = $row['slug'];
  $loc = $base_url . "/meme/" . $slug . "/latest/";
  $lastmod = $row['publish_time'];
  $lastmod = gmdate('Y-m-d', $lastmod);

?>
<url><loc><?php echo $loc; ?></loc><lastmod><?php echo $lastmod; ?></lastmod><changefreq>monthly</changefreq><priority>0.8</priority></url>
<?php } ?></urlset>
<?php
$string = ob_get_clean();
$sitemapfile = $php_base_directory . "/meme_sitemap.xml";
$fp = fopen($sitemapfile, "w+");
fwrite($fp, $string);
fclose($fp);







ob_start();
?><?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">
<?php

$mysqlquery="SELECT * FROM videos WHERE status = '2' AND sfw = '2' ORDER BY publish_time DESC";
$res=$dbconn->query($mysqlquery) or die(mysqli_error($dbconn));
while($row=$res->fetch_assoc()) {

  $id = $row['id'];
  $slug = $row['slug'];
  $loc = $base_url . "/video/" . $slug . "/latest/";
  $lastmod = $row['post_time'];
  $lastmod = gmdate('Y-m-d', $lastmod);

?>
<url><loc><?php echo $loc; ?></loc><lastmod><?php echo $lastmod; ?></lastmod><changefreq>monthly</changefreq><priority>0.8</priority></url>
<?php } ?></urlset>
<?php
$string = ob_get_clean();
$sitemapfile = $php_base_directory . "/videos_sitemap.xml";
$fp = fopen($sitemapfile, "w+");
fwrite($fp, $string);
fclose($fp);

 ?>
