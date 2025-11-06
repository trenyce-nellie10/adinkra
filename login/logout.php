<?php
require_once("../settings/core.php");
session_destroy();
header("Location: index.php");
exit;
