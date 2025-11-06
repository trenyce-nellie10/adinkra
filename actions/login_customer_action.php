<?php
// actions/login_customer_action.php
require_once("../controllers/customer_controller.php");
require_once("../core.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        echo json_encode(["status" => "error", "message" => "Email and password are required"]);
        exit;
    }

    $res = login_customer_ctr(['email' => $email, 'password' => $password]);

    if ($res['status'] === 'success') {
        // Set sessions
        $_SESSION['user_id']   = $res['payload']['customer_id'];
        $_SESSION['full_name'] = $res['payload']['full_name'];
        $_SESSION['email']     = $res['payload']['email'];
        $_SESSION['user_role'] = $res['payload']['user_role'];
    }

    echo json_encode($res);
    exit;
}

echo json_encode(["status" => "error", "message" => "Invalid request"]);
