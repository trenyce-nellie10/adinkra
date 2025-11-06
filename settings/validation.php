<?php
// validation.php - Schema-compliant field validation

function validate_customer_fields($data) {
    $errors = [];
    
    // customer_name - required, 100 chars max
    if (empty($data['full_name'] ?? '')) {
        $errors[] = "Full name is required";
    } elseif (strlen($data['full_name']) > 100) {
        $errors[] = "Full name must be 100 characters or less";
    }
    
    // customer_email - required, 50 chars max, valid email
    if (empty($data['email'] ?? '')) {
        $errors[] = "Email is required";
    } elseif (strlen($data['email']) > 50) {
        $errors[] = "Email must be 50 characters or less";
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    // customer_pass - required, 150 chars max (for hashed storage)
    if (empty($data['password'] ?? '')) {
        $errors[] = "Password is required";
    } elseif (strlen($data['password']) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }
    
    // customer_contact - required, 15 chars max
    if (empty($data['contact_number'] ?? '')) {
        $errors[] = "Contact number is required";
    } elseif (strlen($data['contact_number']) > 15) {
        $errors[] = "Contact number must be 15 characters or less";
    }
    
    return $errors;
}

function validate_product_fields($data) {
    $errors = [];
    
    // product_title - required, 200 chars max
    if (empty($data['title'] ?? '')) {
        $errors[] = "Product title is required";
    } elseif (strlen($data['title']) > 200) {
        $errors[] = "Product title must be 200 characters or less";
    }
    
    // product_price - required, must be numeric and positive
    if (!isset($data['price']) || $data['price'] === '') {
        $errors[] = "Product price is required";
    } elseif (!is_numeric($data['price']) || $data['price'] < 0) {
        $errors[] = "Product price must be a positive number";
    }
    
    // product_desc - optional, 500 chars max
    if (!empty($data['description']) && strlen($data['description']) > 500) {
        $errors[] = "Product description must be 500 characters or less";
    }
    
    // product_keywords - optional, 100 chars max
    if (!empty($data['keywords']) && strlen($data['keywords']) > 100) {
        $errors[] = "Product keywords must be 100 characters or less";
    }
    
    // product_cat - required, must be positive integer
    if (empty($data['cat_id']) || !filter_var($data['cat_id'], FILTER_VALIDATE_INT) || $data['cat_id'] <= 0) {
        $errors[] = "Valid category is required";
    }
    
    // product_brand - required, must be positive integer
    if (empty($data['brand_id']) || !filter_var($data['brand_id'], FILTER_VALIDATE_INT) || $data['brand_id'] <= 0) {
        $errors[] = "Valid brand is required";
    }
    
    return $errors;
}

function validate_brand_fields($data) {
    $errors = [];
    
    // brand_name - required, 100 chars max
    if (empty($data['brand_name'] ?? '')) {
        $errors[] = "Brand name is required";
    } elseif (strlen($data['brand_name']) > 100) {
        $errors[] = "Brand name must be 100 characters or less";
    }
    
    return $errors;
}