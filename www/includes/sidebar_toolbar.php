<div class="member-controls sub-controls dark">

  <div class="member-header">
    Options
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() { 
      $('.user-view-order').click(function() {
        var current_choice = <?php echo $view_order; ?>;
        var new_choice = $(this).attr('data-order');
        if (current_choice != new_choice) {
          $('.tools-loading').addClass('active');
          var theurl = "<?php echo $base_url; ?>/change-view-order/" + new_choice + "/";
          $.ajax({
            url: theurl,
            type: 'get',
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
              if (response.status == 1) {
                $('.tools-loading').removeClass('active');
                location.reload();
              } else {
                $('.tools-loading').removeClass('active');
              };

            }
          });
        }
      });

      $('.hide-shit').click(function() {
        var current_choice = <?php echo $current_shit_choice = $hide_shit; ?>;
        var new_choice = <?php if ($current_shit_choice == 0) {
                            $current_shit_choice = 1;
                          } else {
                            $current_shit_choice = 0;
                          }
                          echo $current_shit_choice; ?>

        $('.tools-loading').addClass('active');
        var theurl = "<?php echo $base_url; ?>/hide-shit/" + new_choice + "/";

        $.ajax({
          url: theurl,
          type: 'get',
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 1) {
              $('.tools-loading').removeClass('active');
              location.reload();
            } else {
              $('.tools-loading').removeClass('active');
            };

          }
        });
      });
    });
  </script>

  <div class="member-controls-row">
    <a class="member-control viewby-date-asc <?php if ($view_order == 0) {
                                                echo "active";
                                              } ?> user-view-order" data-order="0" ;>
      <?php include($php_base_directory . '/styles/images/svgs/hourglass-icon.svg'); ?>
      <span class="social-networks-tool-tip one-five">
        VIEW LATEST FIRST
        <svg class="tooltip-arrow one-five" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
          <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
          c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z" />
        </svg>
      </span>
    </a>
    <a class="member-control viewby-date-desc <?php if ($view_order == 1) {
                                                echo "active";
                                              } ?> user-view-order" data-order="1" ;>
      <?php include($php_base_directory . '/styles/images/svgs/hourglass-icon.svg'); ?>
      <span class="social-networks-tool-tip two-five">
        VIEW OLDEST FIRST
        <svg class="tooltip-arrow two-five" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
          <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
          c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z" />
        </svg>
      </span>
    </a>
    <a class="member-control viewby-rating <?php if ($view_order == 2) {
                                              echo "active";
                                            } ?> user-view-order" data-order="2" ;>
      <?php include($php_base_directory . '/styles/images/svgs/fist-icon.svg'); ?>
      <span class="social-networks-tool-tip three-five">
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
      <span class="social-networks-tool-tip four-five">
        HIDE LOW RATED
        <svg class="tooltip-arrow four-five" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
          <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
          c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z" />
        </svg>
      </span>
    </a>
    <a href="<?php echo $base_url; ?>/printable/" target="_blank" class="member-control printer-version">
      <?php include($php_base_directory . '/styles/images/svgs/printer-icon.svg'); ?>
      <span class="social-networks-tool-tip five-five">
        PRINTER FRIENDLY BRO CODE
        <svg class="tooltip-arrow five-five" version="1.1" id="Capa_1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 42 31" style="enable-background:new 0 0 42 31;" xml:space="preserve">
          <path d="M21.8,30.6l20-29c0.2-0.3,0.2-0.7,0.1-1C41.7,0.2,41.4,0,41,0L1,0C0.6,0,0.3,0.2,0.1,0.5C0,0.7,0,0.8,0,1
          c0,0.2,0.1,0.4,0.2,0.6l20,29c0.2,0.3,0.5,0.4,0.8,0.4C21.3,31,21.6,30.8,21.8,30.6z" />
        </svg>
      </span>
    </a>
  </div>

  <?php if ($code_toolbar == 1) : ?>
    <div class="member-controls-row of-hidden">
      <a class="member-control <?php if ($suggest_code_open == 1) {
                                  echo "current";
                                } ?>" href="<?php echo $base_url ?>/suggest-code/">
        Suggest A Code
      </a>
      <a class="member-control <?php if ($suggestions_open == 1) {
                                  echo "current";
                                } ?>" href="<?php echo $base_url ?>/code-suggestions/">
        View Suggestions
      </a>
    </div>
  <?php endif; ?>

  <?php if ($board_toolbar == 1) : ?>
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
  <?php endif; ?>




  <div class="loading tools-loading">
    <?php include($php_base_directory . '/includes/loading.php'); ?>
  </div>
</div>