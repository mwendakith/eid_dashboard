<?php
$burl=basename($_SERVER['REQUEST_URI']);
header("Location: https://eiddash.nascop.org/$burl");
die();
// basename($_SERVER['REQUEST_URI']);
?>