<?php ob_start(); ?>
<?php
$db['host'] = 'localhost';
$db['user'] = 'phpuser';
$db['pass'] = 'qw204080';
$db['db'] = 'cms';

foreach($db as $key => $value) {
  define(strtoupper($key), $value);
}

$connection = mysqli_connect(HOST, USER, PASS, DB);
// if ($connection) {
//   echo 'we are connected to db';
// }

?>
