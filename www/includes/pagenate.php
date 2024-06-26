<div class='meta-link-no-hover mobile-full mobile-mini-header'>Page <?php echo $page; ?> of <?php if ($pages == 0) {
                                                                                              echo "1";
                                                                                            } else {
                                                                                              echo $pages;
                                                                                            }; ?></div>
<?php if ($page == 1) { ?>
  <div class='meta-link-no-hover current'>1</div>
  <?php if ($pages > 1) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/2/<?php echo $postfix; ?>' class='meta-link'>2</a><?php } ?>
  <?php if ($pages > 2) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/3/<?php echo $postfix; ?>' class='meta-link'>3</a><?php } ?>
  <?php if ($pages > 3) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/4/<?php echo $postfix; ?>' class='meta-link'>4</a><?php } ?>
  <?php if ($pages > 4) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/5/<?php echo $postfix; ?>' class='meta-link'>5</a><?php } ?>
  <?php if ($pages > 5) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/6/<?php echo $postfix; ?>' class='meta-link'>6</a><?php } ?>
  <?php if ($pages > 6) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/7/<?php echo $postfix; ?>' class='meta-link'>7</a><?php } ?>
<?php } else if ($page == 2) { ?>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php if (!$postfix == null) {
                                                            echo "1/" . $postfix;
                                                          }; ?>' class='meta-link'>1</a>
  <div class='meta-link-no-hover current'>2</div>
  <?php if ($pages > 2) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/3/<?php echo $postfix; ?>' class='meta-link'>3</a><?php } ?>
  <?php if ($pages > 3) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/4/<?php echo $postfix; ?>' class='meta-link'>4</a><?php } ?>
  <?php if ($pages > 4) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/5/<?php echo $postfix; ?>' class='meta-link'>5</a><?php } ?>
  <?php if ($pages > 5) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/6/<?php echo $postfix; ?>' class='meta-link'>6</a><?php } ?>
  <?php if ($pages > 6) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/7/<?php echo $postfix; ?>' class='meta-link'>7</a><?php } ?>
<?php } else if ($page == 3) { ?>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php if (!$postfix == null) {
                                                            echo "1/" . $postfix;
                                                          }; ?>' class='meta-link'>1</a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/2/<?php echo $postfix; ?>' class='meta-link'>2</a>
  <div class='meta-link-no-hover current'>3</div>
  <?php if ($pages > 3) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/4/<?php echo $postfix; ?>' class='meta-link'>4</a><?php } ?>
  <?php if ($pages > 4) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/5/<?php echo $postfix; ?>' class='meta-link'>5</a><?php } ?>
  <?php if ($pages > 5) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/6/<?php echo $postfix; ?>' class='meta-link'>6</a><?php } ?>
  <?php if ($pages > 6) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/7/<?php echo $postfix; ?>' class='meta-link'>7</a><?php } ?>
<?php } else if ($page == 4) { ?>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php if (!$postfix == null) {
                                                            echo "1/" . $postfix;
                                                          }; ?>' class='meta-link'>1</a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/2/<?php echo $postfix; ?>' class='meta-link'>2</a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/3/<?php echo $postfix; ?>' class='meta-link'>3</a>
  <div class='meta-link-no-hover current'>4</div>
  <?php if ($pages > 4) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/5/<?php echo $postfix; ?>' class='meta-link'>5</a><?php } ?>
  <?php if ($pages > 5) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/6/<?php echo $postfix; ?>' class='meta-link'>6</a><?php } ?>
  <?php if ($pages > 6) { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/7/<?php echo $postfix; ?>' class='meta-link'>7</a><?php } ?>
<?php } else if ($page == ($pages - 4)) { ?>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page - 2; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page - 2; ?></a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page - 1; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page - 1; ?></a>
  <div class='meta-link-no-hover current'><?php echo $page ?></div>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page + 1; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page + 1; ?></a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page + 2; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page + 2; ?></a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page + 3; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page + 3; ?></a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page + 4; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page - 4; ?></a>
<?php } else if ($page == ($pages - 3)) { ?>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page - 3; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page - 3; ?></a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page - 2; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page - 2; ?></a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page - 1; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page - 1; ?></a>
  <div class='meta-link-no-hover current'><?php echo $page ?></div>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page + 1; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page + 1; ?></a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page + 2; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page + 2; ?></a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page + 3; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page + 3; ?></a>
<?php } else if ($page == ($pages - 2)) { ?>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page - 4; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page - 4; ?></a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page - 3; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page - 3; ?></a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page - 2; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page - 2; ?></a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page - 1; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page - 1; ?></a>
  <div class='meta-link-no-hover current'><?php echo $page ?></div>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page + 1; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page + 1; ?></a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page + 2; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page + 2; ?></a>
<?php } else if ($page == ($pages - 1)) { ?>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page - 5; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page - 5; ?></a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page - 4; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page - 4; ?></a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page - 4; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page - 3; ?></a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page - 2; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page - 2; ?></a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page - 1; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page - 1; ?></a>
  <div class='meta-link-no-hover current'><?php echo $page ?></div>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page + 1; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page + 1; ?></a>
<?php } else if ($page == ($pages)) { ?>
  <?php if (($page - 6) < 1) {
  } else { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page - 6; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page - 6; ?></a><?php } ?>
  <?php if (($page - 5) < 1) {
  } else { ?><a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page - 5; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page - 5; ?></a><?php } ?>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page - 4; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page - 4; ?></a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page - 3; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page - 3; ?></a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page - 2; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page - 2; ?></a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page - 1; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page - 1; ?></a>
  <div class='meta-link-no-hover current'><?php echo $page ?></div>
<?php } else { ?>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page - 3; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page - 3; ?></a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page - 2; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page - 2; ?></a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page - 1; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page - 1; ?></a>
  <div class='meta-link-no-hover current'><?php echo $page ?></div>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page + 1; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page + 1; ?></a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page + 2; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page + 2; ?></a>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $page + 3; ?>/<?php echo $postfix; ?>' class='meta-link'><?php echo $page + 3; ?></a>
<?php }
if ($page < ($pages - 4)) { ?>
  <a href='<?php echo $base_url ?>/<?php echo $prefix; ?>/<?php echo $pages ?>/<?php echo $postfix; ?>' class='meta-link'>Last</a>
<?php } ?>