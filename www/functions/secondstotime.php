<?php
function secondsToTime($seconds) {

    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");

    if ($seconds < 60) {
      return $dtF->diff($dtT)->format('%s seconds');
    }
    else if ($seconds < 3600) {
      return $dtF->diff($dtT)->format('%i minutes');
    }
    else if ($seconds < 172800) {
      return $dtF->diff($dtT)->format('%h hours');
    }
    else if ($seconds > 172800) {
      return $dtF->diff($dtT)->format('%a days');
    }
    return 'yes';
}

?>
