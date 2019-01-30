<?php
$burl=basename($_SERVER['REQUEST_URI']);
header("Location: http://eiddash.test.nascop.org/$burl");
die();
// basename($_SERVER['REQUEST_URI']);
?>