<!-- how to parse ini file -->

<?php
print_r(parse_ini_file('awb_config.ini'));

echo(parse_ini_file('awb_config.ini')['dbHostName']);

?>