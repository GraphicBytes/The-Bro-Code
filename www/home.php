<?php
$pagetitle = "The Bro Code - Internet Stuff For Bros";
$pagedescription = "A Bro's best source for Videos, Memes, Guides, Discussion, Advice and the world famous Bro Code.";
$canonical = $base_url;
$home_css = 1;
$home_body_css = 1;
$mainmenu = 0;
$sfw = 2;
include($php_base_directory . '/header.php');
?>


<div class="full-page-flex">

  <div class="page-left">

    <div class="inner-page-left">
      <a href="<?php echo $base_url ?>" class="logo-contain mobile-hide">
        <?php include($php_base_directory . '/styles/images/svgs/logo.svg'); ?>
      </a>

      <?php if ($logged_in_id > 0) { ?>

        <div class="member-controls home">

          <div id="member-header-user" class="member-header-user">
            <?php echo $user_display_name ?>
          </div>

          <div class="member-controls-row home">

            <?php if ($logged_in_id == 99999) : ?>
              <a class="member-control home">
                <?php include($php_base_directory . '/styles/images/svgs/bell-icon.svg'); ?>
                <span class="tool-tip mobile-hide">
                  NOTIFICATIONS
                  <svg class="tooltip-arrow" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
                    <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
                    c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z" />
                  </svg>
                </span>
              </a>
            <?php endif; ?>

            <?php if ($logged_in_id == 99999) : ?>
              <a class="member-control home" href="<?php echo $base_url ?>/user-memes/">
                <?php include($php_base_directory . '/styles/images/svgs/memes-icon.svg'); ?>
                <span class="tool-tip mobile-hide">
                  YOUR MEMES
                  <svg class="tooltip-arrow" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
                    <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
                    c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z" />
                  </svg>
                </span>
              </a>
            <?php endif; ?>

            <?php if ($logged_in_id == 99999) : ?>
              <a class="member-control home" href="<?php echo $base_url ?>/user-codes/">
                <?php include($php_base_directory . '/styles/images/svgs/code-icon.svg'); ?>
                <span class="tool-tip mobile-hide">
                  YOUR CODE SUGGESTIONS
                  <svg class="tooltip-arrow" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
                    <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
                    c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z" />
                  </svg>
                </span>
              </a>
            <?php endif; ?>

            <?php if ($logged_in_id == 99999) : ?>
              <a class="member-control home" href="<?php echo $base_url ?>/user-board-activity/">
                <?php include($php_base_directory . '/styles/images/svgs/chat-icon.svg'); ?>
                <span class="tool-tip mobile-hide">
                  MESSAGE BOARD ACTIVITY
                  <svg class="tooltip-arrow" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
                    <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
                    c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z" />
                  </svg>
                </span>
              </a>
            <?php endif; ?>

            <a class="member-control edit-profile-link home">
              <img class="user-icon profile-icon" src="<?php echo $base_url ?>/styles/images/svgs/user-icon.svg?v=<?php echo $generator_v_num; ?>" alt="The Bro Code - Edit Your Profile" /> 
              <span class="tool-tip edit-profile ">
                EDIT YOUR PROFILE
                <svg class="tooltip-arrow edit-profile" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
                  <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
                  c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z" />
                </svg>
              </span>
              <span class="member-control-label">PROFILE</span>
            </a>
            <a class="member-control home" href="<?php echo $base_url ?>/logout/">
              <?php include($php_base_directory . '/styles/images/svgs/logout-icon.svg'); ?>
              <span class="tool-tip log-out">
                LOGOUT
                <svg class="tooltip-arrow log-out" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
                  <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
                  c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z" />
                </svg>
              </span>
              <span class="member-control-label">LOG OUT</span>
            </a>
            <a class="member-control home" href="<?php echo $base_url ?>/tncs/">
              <?php include($php_base_directory . '/styles/images/svgs/terms-icon.svg'); ?>
              <span class="tool-tip tncs">
                REVIEW OUR T&amp;Cs
                <svg class="tooltip-arrow tncs" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
                  <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
                  c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z" />
                </svg>
              </span>
              <span class="member-control-label">T&amp;Cs</span>
            </a>

          </div>

        </div>

      <?php } else { ?>

        <div class="login-form">

          <div class="loading invisible login-loading">
            <?php include($php_base_directory . '/includes/loading.php'); ?>
          </div>

          <div class="inner-login-form signup" id="signup-container">
            <div class="login-block">
              <h5 class="login-header">SIGN UP</h5>
              <form method="post" id="signup" name="signup" action="<?php echo $base_url; ?>/signup/" enctype="multipart/form-data">
                <input class="home-login-field sign-up-field" placeholder="Display Name" type="text" name="display_name">
                <input class="home-login-field sign-up-field" placeholder="Email" type="email" name="email">
                <input class="home-login-field sign-up-field" placeholder="Password" type="password" name="passworda">
                <input class="home-login-field sign-up-field" placeholder="Repeat Password" type="password" name="passwordb">
                <input type="hidden" name="bounceback" value="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; ?>">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

                <div class="login-buttons">
                  <input class="home-login-submit signup-go" type="submit" value="SIGN UP" />
                  <div class="log-in log-in-select">Log In</div>
                </div>

              </form>
              <div class="login-message signup-message">

              </div>
            </div>
          </div>

          <div class="inner-login-form lost-pw" id="lost-pw-container">
            <div class="login-block">
              <h5 class="login-header">LOST PASSWORD?</h5>
              <form method="post" id="lostpw" name="lostpw" action="<?php echo $base_url; ?>/lostpw/" enctype="multipart/form-data">
                <input class="home-login-field" placeholder="Email" type="text" name="email">
                <input type="hidden" name="bounceback" value="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; ?>">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

                <div class="login-buttons">
                  <input class="home-login-submit lostpw-go" type="submit" value="RESET PASSWORD" />
                  <div class="log-in log-in-select2">Log In</div>
                </div>

              </form>
              <div class="login-message lost-pw-message">

              </div>
            </div>
          </div>

          <div class="inner-login-form login" id="login-container">
            <div class="login-block">
              <h5 class="login-header">LOGIN</h5>
              <form method="post" id="login" name="login" action="<?php echo $base_url; ?>/logincheck/email/" enctype="multipart/form-data">
                <input class="home-login-field" placeholder="Email" type="text" name="email">
                <input class="home-login-field" placeholder="Password" type="password" name="password">
                <input type="hidden" name="bounceback" value="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; ?>">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

                <div class="login-buttons">
                  <input class="home-login-submit login-go" type="submit" value="GO" />
                  <input id="remember_me" type="hidden" name="remember_me" value="0">
                  <div class="remember-me">REMEMBER ME</div>
                </div>

                <div class="login-buttons">
                  <div class="sign-up sign-up-select">Sign Up</div>
                  <div class="lost-password lost-password-select">Lost Password</div>
                </div>

              </form>
              <div class="login-message log-in-message">
                <?php if ($page == "nowsignedup") : ?>
                  Thank you for validating your email, you can now login.
                <?php endif; ?>
                <?php if ($page == "pwreset") : ?>
                  A temporary password will now be emailed to you.
                <?php endif; ?>
              </div>

            </div>
          </div>
        </div>

      <?php } ?>


      <div class="social-networks-flex <?php if ($logged_in_id < 1) {
                                          echo "social-networks-flex-logged-out";
                                        } ?>">
        <a class="home-social-bubble reddit" rel="nofollow" target="_blank" href="https://www.reddit.com/r/BROCODE/">
          <svg class="social-reddit-icon" version="1.1" id="Layer_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24 20" style="enable-background:new 0 0 24 20;" xml:space="preserve">
            <path d="M24,9.8c0-1.5-1.2-2.6-2.7-2.6c-0.7,0-1.4,0.3-1.8,0.7c-1.8-1.2-4.3-1.9-7-2L14,1.2l4,0.9v0.1c0,1.2,1,2.2,2.2,2.2
            s2.2-1,2.2-2.2S21.4,0,20.2,0c-0.9,0-1.7,0.6-2,1.4l-4.3-1c-0.2,0-0.4,0.1-0.4,0.2l-1.7,5.2c-2.8,0-5.4,0.8-7.3,2
            C4,7.4,3.4,7.1,2.7,7.1C1.2,7.1,0,8.3,0,9.8c0,1,0.5,1.8,1.3,2.3c-0.1,0.3-0.1,0.6-0.1,0.9c0,3.8,4.8,7,10.7,7s10.7-3.2,10.7-7.1
            c0-0.3,0-0.5-0.1-0.8C23.4,11.7,24,10.8,24,9.8z M6.8,11.6c0-0.9,0.7-1.6,1.6-1.6s1.6,0.7,1.6,1.6s-0.7,1.6-1.6,1.6
            S6.8,12.5,6.8,11.6z M15.8,16.3c-0.8,0.8-2,1.2-3.8,1.2l0,0l0,0c-1.8,0-3-0.4-3.8-1.2c-0.1-0.1-0.1-0.4,0-0.5s0.4-0.1,0.5,0
            c0.6,0.6,1.7,1,3.3,1l0,0l0,0c1.6,0,2.6-0.3,3.3-1c0.1-0.1,0.4-0.1,0.5,0C16,15.9,16,16.1,15.8,16.3z M15.6,13.2
            c-0.9,0-1.6-0.7-1.6-1.6s0.7-1.6,1.6-1.6c0.9,0,1.6,0.7,1.6,1.6S16.5,13.2,15.6,13.2z" />
          </svg>
          <span class="social-networks-tool-tip mobile-hide">
            SUBSCRIBE TO THE BRO CODE SUBREDDIT
            <svg class="tooltip-arrow" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
              <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
              c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z" />
            </svg>
          </span>
        </a>
        <a class="home-social-bubble facebook" rel="nofollow" target="_blank" href="https://www.facebook.com/brocode.org/">
          <svg class="social-facebook-icon" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 52 96.1" style="enable-background:new 0 0 52 96.1;" xml:space="preserve">
            <g>
              <path d="M50,0L37.5,0c-14,0-23.1,9.3-23.1,23.7v10.9H2c-1.1,0-2,0.9-2,2v15.8c0,1.1,0.9,2,2,2h12.5v39.9c0,1.1,0.9,2,2,2h16.4
              c1.1,0,2-0.9,2-2V54.3h14.7c1.1,0,2-0.9,2-2l0-15.8c0-0.5-0.2-1-0.6-1.4s-0.9-0.6-1.4-0.6H34.8v-9.2c0-4.4,1.1-6.7,6.8-6.7l8.4,0
              c1.1,0,2-0.9,2-2V2C52,0.9,51.1,0,50,0z" />
            </g>
          </svg>
          <span class="social-networks-tool-tip">
            FOLLOW THE BRO CODE ON FACEBOOK
            <svg class="tooltip-arrow" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
              <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
              c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z" />
            </svg>
          </span>
        </a>
        <a class="home-social-bubble discord" rel="nofollow" target="_blank" href="https://discord.gg/pPJVpY5">
          <svg class="social-discord-icon" version="1.1" id="Layer_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 382.3 332.2" style="enable-background:new 0 0 382.3 332.2;" xml:space="preserve">
            <path d="M353.3,20.8l-1.3-3.2c0-0.1-0.1-0.2-0.2-0.2l-3.1-1.4C322.9,4.2,286.4,1.3,254.2,0h-36.3c-0.4,0-0.5,0.6-0.2,0.7l74.6,35.8
            c0.4,0.2,0.2,0.8-0.3,0.7C258.5,28.4,224.6,24,191.1,24c-33.4,0-67.1,4.4-100.6,13.1c-0.5,0.1-0.7-0.5-0.3-0.7l77.2-35.7
            c0.4-0.2,0.3-0.7-0.2-0.7h-39.3C95.9,1.3,59.4,4.2,33.6,15.9l-3.1,1.4c-0.1,0-0.2,0.1-0.2,0.2L29,20.8C2.5,87.7-5,201.5,3,272.7
            l0.4,3.7l3,2.3c41.3,32,96.5,48.5,131.3,52.9l4.5,0.6c1.5,0.2,2.9-0.7,3.4-2l22.6-60.4c0.7-1.9-0.5-3.9-2.5-4.3l-6.9-1.1
            c-24.2-3.8-58.5-13.9-87.4-40.1c-0.6-0.6,0-1.6,0.8-1.3c2.4,0.9,4.9,1.9,7.6,2.9c6.6,2.6,13.3,5.2,17.7,6.3
            c31.1,7.4,62.6,11.1,93.7,11.1v-0.6h0.1l0,0.6c31.1,0,62.6-3.7,93.6-11.1c4.4-1.1,11.2-3.7,17.7-6.3c2.7-1,5.3-2.1,7.6-2.9
            c0.8-0.3,1.4,0.7,0.8,1.3c-28.9,26.2-63.2,36.2-87.4,40l-6.9,1.1c-2,0.3-3.2,2.4-2.5,4.2l22.6,60.6c0.5,1.4,1.9,2.2,3.4,2l4.5-0.6
            c34.7-4.4,90-20.8,131.3-52.9l3-2.3l0.4-3.7C387.2,201.5,379.7,87.7,353.3,20.8z M117.3,185.2c-28.1,2.5-51.5-20.9-49-49
            c1.9-21.5,19.3-38.9,40.8-40.8c28.1-2.5,51.5,20.9,49,49C156.2,166,138.9,183.3,117.3,185.2z M273.2,185.2
            c-28.1,2.5-51.5-20.9-49-49c1.9-21.5,19.3-38.9,40.8-40.8c28.1-2.5,51.5,20.9,49,49C312,166,294.7,183.3,273.2,185.2z" />
          </svg>
          <span class="social-networks-tool-tip">
            JOIN THE BRO CODE DISCORD SERVER
            <svg class="tooltip-arrow" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
              <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
              c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z" />
            </svg>
          </span>
        </a>
      </div>

      <div class="home-footer">
        <a href="<?php echo $base_url ?>/terms/" rel="nofollow">TERMS</a>|
        <a href="<?php echo $base_url ?>/privacy/" rel="nofollow">PRIVACY</a>|
        <a href="<?php echo $base_url ?>/about/" rel="nofollow">ABOUT</a>|
        <a href="<?php echo $base_url ?>/dmca/" rel="nofollow">DMCA</a>|
        <a href="<?php echo $base_url ?>/contact/" rel="nofollow">CONTACT</a>
      </div>

    </div>

  </div>
  <div class="page-right">

    <div class="inner-page-right">

      <a href="<?php echo $base_url ?>" class="logo-contain desktop-hide">
        <?php include($php_base_directory . '/styles/images/svgs/logo.svg'); ?>
      </a>

      <a class="hero-link-big" href="<?php echo $base_url ?>/the-code/">
        <span class="hero-link-bg-image" style="background-image:url('<?php echo $static_url; ?>/images/tiles/fist-bump.jpg');"></span>
        <span class="hero-link-title">THE CODE</span>
      </a>

      <a class="hero-link-big sub" href="<?php echo $base_url ?>/code-suggestions/">
        <span class="hero-link-bg-image" style="background-image:url('<?php echo $static_url; ?>/images/tiles/gavel.jpg');"></span>
        <span class="hero-link-title">VIEW CODE<br />SUGGESTIONS</span>
      </a>

      <a class="hero-link-big sub" href="<?php echo $base_url ?>/suggest-code/">
        <span class="hero-link-bg-image" style="background-image:url('<?php echo $static_url; ?>/images/tiles/book-and-pen.jpg');"></span>
        <span class="hero-link-title">SUBMIT A NEW<br />BRO CODE</span>
      </a>

      <?php if ($logged_in_id == 99999 or $dev_lock = 0) : ?>
        <a class="hero-link-big" href="<?php echo $base_url ?>/boards/">
          <span class="hero-link-bg-image" style="background-image:url('<?php echo $static_url; ?>/pageimages/home/boards-full.jpg');"></span>
          <span class="hero-link-title">BOARDS</span>
        </a>
      <?php endif; ?>

      <?php if ($logged_in_id == 99999) : ?>
        <a class="hero-link" href="<?php echo $base_url ?>/greeting-guide/">
          <span class="hero-link-bg-image" style="background-image:url('<?php echo $static_url; ?>/pageimages/home/greeting-guide-full.jpg');"></span>
          <span class="hero-link-title">GREETING GUIDE</span>
        </a>
      <?php endif; ?>


      <?php if ($logged_in_id == 99999) : ?>
        <a class="hero-link" href="<?php echo $base_url ?>/a-quick-guide-to-urinal-etiquette/">
          <span class="hero-link-bg-image" style="background-image:url('<?php echo $static_url; ?>/pageimages/home/urinal-etiquette-full.jpg');"></span>
          <span class="hero-link-title">URINAL ETIQUETTE</span>
        </a>
      <?php endif; ?>



    </div>

  </div>

</div>




<?php
include($php_base_directory . '/footer.php');
?>