<?php
require_once(__DIR__ . "/../controllers/brand_controller.php");
require_once(__DIR__ . "/../core.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { echo json_encode(['status'=>'error','message'=>'Invalid request']); exit; }

$brand_id = (int)($_POST['brand_id'] ?? 0);
if ($brand_id <= 0) { echo json_encode(['status'=>'error','message'=>'Invalid ID']); exit; }

$res = delete_brand_ctr($brand_id);
echo json_encode($res);
