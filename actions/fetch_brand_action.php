<?php
require_once(__DIR__ . "/../controllers/brand_controller.php");
require_once(__DIR__ . "/../core.php");
header('Content-Type: application/json');
$user_id = is_logged_in() ? $_SESSION['user_id'] : null;
$brands = fetch_brands_ctr($user_id);
echo json_encode($brands);
