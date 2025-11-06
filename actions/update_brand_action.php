<?php
require_once(__DIR__ . "/../controllers/brand_controller.php");
require_once(__DIR__ . "/../core.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { echo json_encode(['status'=>'error','message'=>'Invalid request']); exit; }

$brand_id = (int)($_POST['brand_id'] ?? 0);
$brand_name = trim($_POST['brand_name'] ?? '');
if ($brand_id <= 0 || $brand_name === '') {
    echo json_encode(['status'=>'error','message'=>'Invalid input']); exit;
}
$res = update_brand_ctr(['brand_id'=>$brand_id, 'brand_name'=>$brand_name]);
echo json_encode($res);
