<?php
require_once("../controllers/customer_controller.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'full_name' => $_POST['full_name'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'country' => $_POST['country'],
        'city' => $_POST['city'],
        'contact_number' => $_POST['contact_number']
    ];

    $response = register_customer_ctr($data);
    echo json_encode($response);
}
?>
