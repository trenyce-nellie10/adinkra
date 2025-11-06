<?php
require_once(__DIR__ . "/../controllers/brand_controller.php");
require_once(__DIR__ . "/../core.php");
header('Content-Type: application/json');

$brand_name = trim($_POST['brand_name'] ?? '');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { echo json_encode(['status'=>'error','message'=>'Invalid request']); exit; }
if ($brand_name === '') {
    echo json_encode(['status'=>'error','message'=>'Invalid input']); exit;
}

$res = add_brand_ctr(['brand_name'=>$brand_name, 'user_id'=>$_SESSION['user_id'] ?? null]);
echo json_encode($res);
