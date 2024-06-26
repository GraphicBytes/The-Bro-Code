<div class="delete-comment-question delete-comment-question-<?php echo $comment_to_delete_id; ?>">
  <p>
    Deleting is permanent and can't be undone!
  </p>

  <div class="delete-final-decision delete-final-decision-<?php echo $comment_to_delete_id; ?>">

    <div class="confirm-comment-delete confirm-comment-delete-<?php echo $comment_to_delete_id; ?>" data-id="<?php echo $comment_to_delete_id; ?>">
      <?php include($php_base_directory . '/styles/images/svgs/delete-icon.svg'); ?>
      <span>Confirm &amp; Delete</span>
    </div>

    <div class="cancel-comment-delete cancel-comment-delete-<?php echo $comment_to_delete_id; ?>">
      <?php include($php_base_directory . '/styles/images/svgs/delete-icon.svg'); ?>
      <span>Cancel</span>
    </div>

  </div>

</div>


<script>
  document.addEventListener("DOMContentLoaded", function() {
    $('.cancel-comment-delete-<?php echo $comment_to_delete_id; ?>').click(function() {
      cancel_delete_comment(<?php echo $comment_to_delete_id; ?>);
    });
    $('.confirm-comment-delete-<?php echo $comment_to_delete_id; ?>').click(function() {
      confirm_delete_comment(<?php echo $comment_to_delete_id; ?>);
    });
  });
</script>