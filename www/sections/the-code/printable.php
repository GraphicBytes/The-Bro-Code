<?php
include($php_base_directory . '/header.php'); ?>

<div class="container">

  <img class="bro-code" src="<?php echo $base_url ?>/styles/images/logo_alt.png" alt="The Bro Code">


  <?php
  $mysqlquery = "SELECT * FROM thecode ORDER BY id ASC";
  $res = $dbconn->query($mysqlquery);
  while ($row = $res->fetch_assoc()) {
    $code_id = $row['id'];
    $content = $row['content'];
    $content = $content;
    $struck_off = $row['struck_off'];
  ?>

    <p <?php if ($struck_off == 1) {
          echo 'class="struck-off"';
        } ?>><strong><?php echo $code_id; ?>)</strong> <?php echo $content; ?></p>

  <?php
  }
  include($php_base_directory . '/footer.php');
  ?>

</div>