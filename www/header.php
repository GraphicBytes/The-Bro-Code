<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <?php if ($viewing_home == 1) : ?>
    <link rel="stylesheet" href="<?php echo $base_url ?>/styles/css/home.css?v=<?php echo $generator_v_num; ?>">
  <?php endif; ?>
  <?php if ($the_code_css == 1) : ?>
    <link rel="stylesheet" href="<?php echo $base_url ?>/styles/css/the-code.css?v=<?php echo $generator_v_num; ?>">
  <?php endif; ?>
  <?php if ($code_css == 1) : ?>
    <link rel="stylesheet" href="<?php echo $base_url ?>/styles/css/code.css?v=<?php echo $generator_v_num; ?>">
  <?php endif; ?>
  <?php if ($legal_css == 1) : ?>
    <link rel="stylesheet" href="<?php echo $base_url ?>/styles/css/legal.css?v=<?php echo $generator_v_num; ?>">
  <?php endif; ?>
  <?php if ($logged_in_id > 0 && $printable_css != 1) : ?>
    <link rel="stylesheet" href="<?php echo $base_url ?>/styles/css/loggedin.css?v=<?php echo $generator_v_num; ?>">
  <?php endif; ?>
  <?php if ($printable_css == 1) : ?>
    <link rel="stylesheet" href="<?php echo $base_url ?>/styles/css/printable.css?v=<?php echo $generator_v_num; ?>">
  <?php endif; ?>
  <?php if ($boards_css == 1) : ?>
    <link rel="stylesheet" href="<?php echo $base_url ?>/styles/css/boards.css?v=<?php echo $generator_v_num; ?>">
  <?php endif; ?>
  <?php if ($topic_css == 1) : ?>
    <link rel="stylesheet" href="<?php echo $base_url ?>/styles/css/topic.css?v=<?php echo $generator_v_num; ?>">
  <?php endif; ?>
  <?php if ($suggest_code_css == 1) : ?>
    <link rel="stylesheet" href="<?php echo $base_url ?>/styles/css/suggest-code.css?v=<?php echo $generator_v_num; ?>">
  <?php endif; ?>
  <?php if ($meme_maker_css == 1) : ?>
    <link rel="stylesheet" href="<?php echo $base_url ?>/styles/css/meme-maker.css?v=<?php echo $generator_v_num; ?>">
  <?php endif; ?>
  <?php if ($logged_in_id == 1 && $printable_css != 1) : ?>
    <link rel="stylesheet" href="<?php echo $base_url ?>/styles/css/system.css?v=<?php echo $generator_v_num; ?>">
  <?php endif; ?>
  <link rel="icon" type="image/x-icon" href="<?php echo $static_url ?>/favicons/favicon.ico">
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $static_url ?>/favicons/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $static_url ?>/favicons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="194x194" href="<?php echo $static_url ?>/favicons/favicon-194x194.png">
  <link rel="icon" type="image/png" sizes="192x192" href="<?php echo $static_url ?>/favicons/android-chrome-192x192.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $static_url ?>/favicons/favicon-16x16.png">
  <link rel="manifest" href="<?php echo $static_url ?>/favicons/site.webmanifest">
  <link rel="mask-icon" href="<?php echo $static_url ?>/favicons/safari-pinned-tab.svg" color="#3b76bb">
  <meta name="apple-mobile-web-app-title" content="The Bro Code">
  <meta name="application-name" content="The Bro Code">
  <meta name="msapplication-TileColor" content="#3b76bb">
  <meta name="msapplication-TileImage" content="<?php echo $static_url ?>/favicons/mstile-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <style>
    *{user-select: none;}
  </style>
  <title><?php echo limit_words($pagetitle, 50); ?></title>
  <meta content="<?php echo limit_words($pagedescription, 150); ?>" name="description" />
  <?php include('config/authour-and-generator-meta.php'); ?>
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
  <?php if ($nofollow == 1) { ?>
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
  <?php } ?>
  <script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "WebSite",
      "name": "The Bro Code",
      "alternateName": "Bro Code",
      "url": "https://brocode.org",
      "sameAs": [
        "https://www.facebook.com/brocode.org/",
        "https://www.reddit.com/r/brocode/"
      ]
    }
  </script>
  <link rel="canonical" href="<?php echo $canonical; ?>" />
  <meta property="og:image" content="<?php echo $og_image; ?>" />
</head>

<body class="body<?php if ($home_body_css == 1) {
                    echo " home";
                  } ?>">

  <?php if ($printable_css != 1) : ?>

    <?php if ($logged_in_id == -1) { ?>
      <div class="banned">
        <h3>YOUR ACCOUNT HAS BEEN BANNED!</h3>
      </div>
    <?php } ?>

    <?php if ($mainmenu == 1) { ?>
      <header class="header">
        <div class="container nopadding">

          <div class="header-left">
            <?php if (isset($_SERVER['HTTP_REFERER'])) { ?>
              <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">
                <?php include($php_base_directory . '/styles/images/svgs/previous.svg'); ?>
              </a>
            <?php } ?>
          </div>
          <div class="header-middle">
            <div class="logo-container">
              <a href="<?php echo $base_url ?>">
                <?php include($php_base_directory . '/styles/images/svgs/logo-small.svg'); ?>
              </a>
            </div>
          </div>
          <div class="header-right mobile-hide">
            <nav class="main-menu">

              <a <?php if ($thecode_menu == 1) { ?>class="current" <?php } ?> href="<?php echo $base_url ?>/the-code/">THE CODE</a>

              <a <?php if ($suggestion_menu == 1) { ?>class="current" <?php } ?> href="<?php echo $base_url ?>/code-suggestions/">SUGGESTIONS</a>

              <a <?php if ($submit_menu == 1) { ?>class="current" <?php } ?> href="<?php echo $base_url ?>/suggest-code/">SUBMIT</a> 

              <a <?php if ($meme_maker_menu == 1) { ?>class="current" <?php } ?> href="<?php echo $base_url ?>/meme-maker/">MEME MAKER</a>

            </nav>
          </div>
          <div class="header-right desktop-hide">
            <button class="hamburger hamburger--squeeze" type="button">
              <span class="hamburger-box">
                <span class="hamburger-inner"></span>
              </span>
            </button>
          </div>
        </div>
      </header>
      <div class="header-fill"></div>
    <?php } ?>
  <?php endif; ?>