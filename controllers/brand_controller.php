<?php
// controllers/brand_controller.php
require_once(__DIR__ . "/../classes/brand_class.php");

function fetch_brands_ctr($user_id = null) {
    $brand = new Brand();
    // schema doesn't associate brands to users in shoppn.sql; return all brands
    return $brand->getAllBrands();
}

function add_brand_ctr($data) {
    $brand = new Brand();
    $ok = $brand->addBrand($data['brand_name'] ?? '');
    return $ok ? ['status'=>'success','message'=>'Brand added'] : ['status'=>'error','message'=>'Could not add brand'];
}

function update_brand_ctr($data) {
    $brand = new Brand();
    $ok = $brand->updateBrand($data['brand_id'], $data['brand_name']);
    return $ok ? ['status'=>'success','message'=>'Brand updated'] : ['status'=>'error','message'=>'Update failed'];
}

function delete_brand_ctr($brand_id) {
    $brand = new Brand();
    $ok = $brand->deleteBrand($brand_id);
    return $ok ? ['status'=>'success','message'=>'Brand deleted'] : ['status'=>'error','message'=>'Delete failed'];
}
