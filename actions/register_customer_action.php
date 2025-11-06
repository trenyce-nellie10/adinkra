<?php
require_once("../controllers/customer_controller.php");
require_once("../settings/validation.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'full_name' => trim($_POST['full_name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'password' => $_POST['password'] ?? '',
        'country' => trim($_POST['country'] ?? ''),
        'city' => trim($_POST['city'] ?? ''),
        'contact_number' => trim($_POST['contact_number'] ?? '')
    ];

    $errors = validate_customer_fields($data);
    if (!empty($errors)) {
        echo json_encode(['status' => 'error', 'message' => implode(', ', $errors)]);
        exit;
    }

    $response = register_customer_ctr($data);
    echo json_encode($response);
}
?>
