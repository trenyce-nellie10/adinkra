<?php
// controllers/customer_controller.php
require_once("../classes/customer_class.php");

function register_customer_ctr($data) {
    $customer = new Customer();
    if ($customer->checkEmail($data['email'])) {
        return ["status" => "error", "message" => "Email already exists"];
    }

    $success = $customer->addCustomer(
        $data['full_name'],
        $data['email'],
        $data['password'],
        $data['country'],
        $data['city'],
        $data['contact_number'],
        $data['user_role'] ?? 2
    );

    return $success
        ? ["status" => "success", "message" => "Registration successful"]
        : ["status" => "error", "message" => "Registration failed"];
}

/** Login controller */
function login_customer_ctr($data) {
    $customer = new Customer();
    $result = $customer->verifyPassword($data['email'], $data['password']);

    if (!$result['ok']) {
        $msg = $result['reason'] === 'not_found' ? "Account not found" : "Invalid credentials";
        return ["status" => "error", "message" => $msg];
    }

    $u = $result['user'];
    // Build the session payload
    return [
        "status" => "success",
        "message" => "Login successful",
        "payload" => [
            "customer_id" => $u['customer_id'],
            "full_name"   => $u['full_name'],
            "email"       => $u['email'],
            "user_role"   => (int)$u['user_role']
        ]
    ];
}
