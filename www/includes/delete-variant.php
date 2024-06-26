<div class="delete-comment-question delete-comment-question-<?php echo $variant_to_delete_id; ?>">
  <p>
    Deleting is permanent and can't be undone!
  </p>

  <div class="delete-final-decision delete-final-decision-<?php echo $variant_to_delete_id; ?>">

    <div class="confirm-comment-delete confirm-variant-delete-<?php echo $variant_to_delete_id; ?>" data-id="<?php echo $variant_to_delete_id; ?>" data-spot="0">
      <?php include($php_base_directory . '/styles/images/svgs/delete-icon.svg'); ?>
      <span>Confirm &amp; Delete</span>
    </div>

    <div class="cancel-comment-delete cancel-variant-delete-<?php echo $variant_to_delete_id; ?>">
      <?php include($php_base_directory . '/styles/images/svgs/delete-icon.svg'); ?>
      <span>Cancel</span>
    </div>

  </div>

</div>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    $('.cancel-variant-delete-<?php echo $variant_to_delete_id; ?>').click(function() {
      cancel_delete_variant(<?php echo $variant_to_delete_id; ?>);
    });
    $('.confirm-variant-delete-<?php echo $variant_to_delete_id; ?>').click(function() {
      confirm_delete_variant(<?php echo $variant_to_delete_id; ?>, <?php echo $spot; ?>);
    });
  });
</script>