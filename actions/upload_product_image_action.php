<?php
// uploads must already exist in webroot: htdocs/adinkra_shop/uploads/
require_once(__DIR__ . "/../core.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status'=>'error','message'=>'Invalid request']);
    exit;
}

if (!isset($_FILES['product_image'])) {
    echo json_encode(['status'=>'error','message'=>'No file uploaded']);
    exit;
}

$uploadDir = __DIR__ . '/../uploads/'; // absolute
if (!is_dir($uploadDir) || !is_writable($uploadDir)) {
    echo json_encode(['status'=>'error','message'=>'Upload folder missing or not writable']);
    exit;
}

$file = $_FILES['product_image'];
$allowed = ['image/jpeg','image/png','image/webp'];

if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['status'=>'error','message'=>'Upload error']);
    exit;
}
if (!in_array(mime_content_type($file['tmp_name']), $allowed)) {
    echo json_encode(['status'=>'error','message'=>'Invalid file type']);
    exit;
}

// create user subfolder if user_id present
$uid = $_SESSION['user_id'] ?? 'guest';
$uFolder = $uploadDir . 'u' . intval($uid) . '/';
if (!is_dir($uFolder)) mkdir($uFolder, 0755, true);

$basename = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', basename($file['name']));
$target = $uFolder . time() . '_' . $basename;

// move and ensure path remains in uploads folder
if (!move_uploaded_file($file['tmp_name'], $target)) {
    echo json_encode(['status'=>'error','message'=>'Could not store file']);
    exit;
}

// return web-accessible relative path
$relPath = 'uploads/u' . intval($uid) . '/' . basename($target);
echo json_encode(['status'=>'success','message'=>'Uploaded', 'path'=>$relPath]);
