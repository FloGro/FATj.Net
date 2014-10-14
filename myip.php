<?php
function getIPs($withV6 = true) {
    preg_match_all('/inet'.($withV6 ? '4?' : '').' addr: ?([^ ]+)/', `sudo ifconfig`, $ips);
    return $ips[1][0];
}
?>