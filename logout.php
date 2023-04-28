<?php

session_start();
$_SERVER["REQUEST_METHOD"] = "";
session_destroy();

header("Location:index.php");
exit;