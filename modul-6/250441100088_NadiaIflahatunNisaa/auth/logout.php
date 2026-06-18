<?php

session_start();

session_destroy();

/*
REDIRECT KE LANDING PAGE
*/
header("Location: ../index.php");

exit;

?>