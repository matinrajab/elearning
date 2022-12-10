<?php 
session_start();
$_SESSION = [];
session_unset();
session_destroy();
//hapus cookie
setcookie('level', '', time() - 3600);
setcookie('name', '', time() - 3600);

header("location: index.php");
exit;
?>
