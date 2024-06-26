<?php if ($logged_in_id > 0) { ?>

  <div class="member-controls dark">

    <div id="member-header-user" class="member-header-user">
      <?php echo $user_display_name ?>
    </div>

    <div class="member-controls-row">
      <?php if ($logged_in_id == 99999) : ?>
        <a class="member-control">
          <?php include($php_base_directory . '/styles/images/svgs/bell-icon.svg'); ?>
          <span class="tool-tip notifications">
            NOTIFICATIONS
            <svg class="tooltip-arrow notifications" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
              <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
                              c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z" />
            </svg>
          </span>
        </a>
      <?php endif; ?>

      <?php if ($logged_in_id == 99999) : ?>
        <a class="member-control" href="<?php echo $base_url ?>/user-memes/">
          <?php include($php_base_directory . '/styles/images/svgs/memes-icon.svg'); ?>
          <span class="tool-tip your-memes">
            YOUR MEMES
            <svg class="tooltip-arrow your-memes" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
              <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
                              c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z" />
            </svg>
          </span>
        </a>
      <?php endif; ?>

      <?php if ($logged_in_id == 99999) : ?>
        <a class="member-control" href="<?php echo $base_url ?>/user-codes/">
          <?php include($php_base_directory . '/styles/images/svgs/code-icon.svg'); ?>
          <span class="tool-tip ">
            YOUR CODE SUGGESTIONS
            <svg class="tooltip-arrow" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
              <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
                              c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z" />
            </svg>
          </span>
        </a>
      <?php endif; ?>

      <?php if ($logged_in_id == 99999) : ?>
        <a class="member-control" href="<?php echo $base_url ?>/user-board-activity/">
          <?php include($php_base_directory . '/styles/images/svgs/chat-icon.svg'); ?>
          <span class="tool-tip ">
            MESSAGE BOARD ACTIVITY
            <svg class="tooltip-arrow" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
              <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
                            c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z" />
            </svg>
          </span>
        </a>
      <?php endif; ?>

      <a class="member-control edit-profile-link">
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
      <a class="member-control " href="<?php echo $base_url ?>/logout/">
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
      <a class="member-control " href="<?php echo $base_url ?>/tncs/">
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


    <div class="member-controls-row">
      <a class="member-control viewby-date-asc <?php if ($view_order == 0) {
                                                  echo "active";
                                                } ?> user-view-order user-view-order-1" data-order="0" ;>
        <?php include($php_base_directory . '/styles/images/svgs/hourglass-icon.svg'); ?>
        <span class="tool-tip one-five">
          VIEW LATEST FIRST
          <svg class="tooltip-arrow one-five" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
            <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
            c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z" />
          </svg>
        </span>
      </a>
      <a class="member-control viewby-date-desc <?php if ($view_order == 1) {
                                                  echo "active";
                                                } ?> user-view-order user-view-order-2" data-order="1" ;>
        <?php include($php_base_directory . '/styles/images/svgs/hourglass-icon.svg'); ?>
        <span class="tool-tip two-five">
          VIEW OLDEST FIRST
          <svg class="tooltip-arrow two-five" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
            <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
            c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z" />
          </svg>
        </span>
      </a>
      <a class="member-control viewby-rating <?php if ($view_order == 2) {
                                                echo "active";
                                              } ?> user-view-order user-view-order-3" data-order="2" ;>
        <?php include($php_base_directory . '/styles/images/svgs/fist-icon.svg'); ?>
        <span class="tool-tip three-five">
          VIEW POPULAR FIRST
          <svg class="tooltip-arrow three-five" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
            <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
            c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z" />
          </svg>
        </span>
      </a>
      <a class="member-control hide-shit <?php if ($hide_shit == 1) {
                                            echo "active";
                                          } ?>">
        <?php include($php_base_directory . '/styles/images/svgs/shit-icon.svg'); ?>
        <span class="tool-tip four-five">
          HIDE LOW RATED
          <svg class="tooltip-arrow four-five" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
            <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
            c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z" />
          </svg>
        </span>
      </a>
      <a href="<?php echo $base_url; ?>/printable/" target="_blank" class="member-control printer-version">
        <?php include($php_base_directory . '/styles/images/svgs/printer-icon.svg'); ?>
        <span class="tool-tip five-five">
          PRINTER FRIENDLY BRO CODE
          <svg class="tooltip-arrow five-five" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
            <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
            c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z" />
          </svg>
        </span>
      </a>
    </div>

    <?php if ($logged_in_id == 1) : ?>
      <div class="member-controls-row of-hidden">
        <span class="member-control slim <?php if ($moderation == 1) {
                                            echo "moderating";
                                          } ?> moderation-trigger">
          MODERATE
        </span>
        <a class="member-control slim next-moderate">
          NEXT UNMODERATED
        </a>
      </div>
    <?php endif; ?>

    <div class="loading tools-loading">
      <?php include($php_base_directory . '/includes/loading.php'); ?>
    </div>
  </div>

  <?php if ($board_toolbar == 1) : ?>
    <div class="member-controls dark">
      <div class="member-controls-row of-hidden">
        <a class="member-control <?php if ($suggest_code_open == 1) {
                                    echo "current";
                                  } ?>" href="<?php echo $base_url ?>/suggest-code/">
          Suggest A Board
        </a>
        <?php if ($moderation == 1) : ?>
          <a class="member-control new-board <?php if ($suggest_code_open == 1) {
                                                echo "current";
                                              } ?>">
            Create A Board
          </a>
          <script>
            document.addEventListener('DOMContentLoaded', function() {
              $('.new-board').on('click', function() {
                $('.new-board-box').slideToggle(500, 'easeOutQuart');
              });
            });
          </script>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>



<?php } else { ?>

  <div class="sidebar-block blue login-form-holder">
    <div class="loading blue login-loading">
      <?php include($php_base_directory . '/includes/loading.php'); ?>
    </div>

    <div class="login-form">
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
              <input id="remember_me" class="remember_me" type="hidden" name="remember_me" value="0">
              <div class="remember-me">REMEMBER ME</div>
              <div class="login_form_break"></div>
            </div>


            <div class="login-buttons">
              <div class="sign-up sign-up-select">Sign Up</div>
              <div class="lost-password lost-password-select">Lost Password</div>
            </div>

          </form>
          <div class="login-message log-in-message">
          </div>
        </div>
      </div>

      <div class="signup-triggered"></div>

    </div>
  </div>

<?php } ?>


<?php if ($code_toolbar == 1 && ($suggest_code_open == 1 or $suggestions_open == 1 or $code_open == 1) or $viewing_meme_maker == 1) : ?>
  <div class="member-controls dark">
    <a class="hero-link-big" href="<?php echo $base_url ?>/the-code/">
      <span class="hero-link-bg-image" style="background-image:url('<?php echo $static_url; ?>/images/tiles/fist-bump.jpg');"></span>
      <span class="hero-link-title">THE CODE</span>
    </a>
  </div>
<?php endif; ?>

<?php if ($code_toolbar == 1 && $suggestions_open != 1 or $viewing_meme_maker == 1) : ?>
  <div class="member-controls dark">
    <a class="hero-link-big sub" href="<?php echo $base_url ?>/code-suggestions/">
      <span class="hero-link-bg-image" style="background-image:url('<?php echo $static_url; ?>/images/tiles/gavel.jpg');"></span>
      <span class="hero-link-title">VIEW BRO CODE<br />SUGGESTIONS</span>
    </a>
  </div>
<?php endif; ?>

<?php if ($code_toolbar == 1 && $suggest_code_open != 1 or $viewing_meme_maker == 1) : ?>
  <div class="member-controls dark">
    <a class="hero-link-big sub" href="<?php echo $base_url ?>/suggest-code/">
      <span class="hero-link-bg-image" style="background-image:url('<?php echo $static_url; ?>/images/tiles/book-and-pen.jpg');"></span>
      <span class="hero-link-title">SUBMIT A NEW<br />BRO CODE</span>
    </a>
  </div>
<?php endif; ?>