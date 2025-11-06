<?php
require_once(__DIR__ . "/../controllers/brand_controller.php");
require_once(__DIR__ . "/../settings/core.php");
header('Content-Type: application/json');

require_once(__DIR__ . "/../settings/validation.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { 
    echo json_encode(['status'=>'error','message'=>'Invalid request']); 
    exit; 
}

$data = ['brand_name' => trim($_POST['brand_name'] ?? '')];
$errors = validate_brand_fields($data);
if (!empty($errors)) {
    echo json_encode(['status'=>'error','message'=>implode(', ', $errors)]);
    exit;
}

$res = add_brand_ctr($data);
echo json_encode($res);
