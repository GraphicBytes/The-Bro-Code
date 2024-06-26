<?php if ($logged_in_id == 1 && $moderation == 1): ?><script>
//moderator specific js

</script>





<?php endif; ?><?php if ($logged_in_id > 0): ?><script>
// member specific js

</script>









<?php endif; ?><?php if ($logged_in_id < 1): ?><script>
//logged out specific js

</script>










<?php endif; ?><script>
//global js

</script>
