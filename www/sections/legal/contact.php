<?php
$pagetitle = "Contact Us";
$pagedescription = "About Brocode.org";
$canonical = "https://brocode.org/contact/";
$nofollow = 1;
$sfw = 2;
include($php_base_directory . '/header.php');

if ($logged_in_id < 1) {
  log_malicious();
}
?>

<div class="container">
  <main class="content">
    <div class="content-block bg bottom-padding">

      <h1 class="page-header hero">
        Contacting brocode.org
        <span class="hero-link-bg-image" style="background-image:url('<?php echo $static_url; ?>/images/tiles/phone-in-hand-large.jpg');"></span>
      </h1>

      <p>If you would like to get in touch with the owners of this website and associated social media accounts here's how.</p>

      <p>EMAIL: <a rel="nofollow" href="mailto:bfam@brocode.org">bfam@brocode.org</a></p>

      <p>REDDIT: <a target="_blank" rel="nofollow" href="https://www.reddit.com/r/brocode/">reddit.com/r/brocode/</a></p>

      <p>FACEBOOK: <a target="_blank" rel="nofollow" href="https://www.facebook.com/brocode.org/">facebook.com/brocode.org</a></p>

      <p>DISCORD: <a target="_blank" rel="nofollow" href="https://discord.gg/pPJVpY5">discord.gg/pPJVpY5</a></p>

    </div>
  </main>

  <aside id="sidebar" class="sidebar">
    <?php include($php_base_directory . '/sidebar.php'); ?>
  </aside>
</div>

<?php
include($php_base_directory . '/footer.php');
?>