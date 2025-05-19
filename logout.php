<?php
session_start();
session_destroy();
header("Location: loginui.html");
exit();
?>
