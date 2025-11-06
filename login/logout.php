<?php
require_once(__DIR__ . "/../settings/core.php");
session_destroy();
header("Location: ../index.php");
exit;
