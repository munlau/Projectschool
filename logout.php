<?php
header('Location: inlog.php');
session_start();
session_unset();
session_destroy();
 ?>