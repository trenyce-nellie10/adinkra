<?php
// controllers/product_controller.php
require_once(__DIR__ . "/../classes/product_class.php");

function add_product_ctr($data) {
    $product = new Product();
    $ok = $product->addProduct($data);
    return $ok ? ['status'=>'success','message'=>'Product added'] : ['status'=>'error','message'=>'Add product failed'];
}

function update_product_ctr($product_id, $data) {
    $product = new Product();
    $ok = $product->updateProduct($product_id, $data);
    return $ok ? ['status'=>'success','message'=>'Product updated'] : ['status'=>'error','message'=>'Update failed'];
}

function fetch_all_products_ctr() {
    $product = new Product();
    return $product->getAllProducts();
}

function fetch_product_ctr($product_id) {
    $product = new Product();
    return $product->getProductById($product_id);
}

function search_products_ctr($q) {
    $product = new Product();
    return $product->searchProducts($q);
}

function filter_products_by_category_ctr($cat_id) {
    $product = new Product();
    return $product->filterByCategory($cat_id);
}

function filter_products_by_brand_ctr($brand_id) {
    $product = new Product();
    return $product->filterByBrand($brand_id);
}
