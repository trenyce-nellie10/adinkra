<?php
require_once(__DIR__ . "/../controllers/product_controller.php");
require_once(__DIR__ . "/../core.php");
header('Content-Type: application/json');

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'fetch_all':
        echo json_encode(fetch_all_products_ctr());
        break;
    case 'fetch_one':
        $id = (int)($_GET['id'] ?? 0);
        echo json_encode(fetch_product_ctr($id));
        break;
    case 'search':
        $q = trim($_GET['q'] ?? '');
        echo json_encode(search_products_ctr($q));
        break;
    case 'filter_cat':
        $cid = (int)($_GET['cat_id'] ?? 0);
        echo json_encode(filter_products_by_category_ctr($cid));
        break;
    case 'filter_brand':
        $bid = (int)($_GET['brand_id'] ?? 0);
        echo json_encode(filter_products_by_brand_ctr($bid));
        break;
    case 'add_product':
        // should be POST
        $data = [
            'cat_id' => (int)($_POST['cat_id'] ?? 0),
            'brand_id' => (int)($_POST['brand_id'] ?? 0),
            'title' => trim($_POST['title'] ?? ''),
            'price' => (float)($_POST['price'] ?? 0),
            'description' => trim($_POST['description'] ?? ''),
            'image_path' => trim($_POST['image_path'] ?? null),
            'keywords' => trim($_POST['keywords'] ?? null),
            'user_id' => $_SESSION['user_id'] ?? null
        ];
        echo json_encode(add_product_ctr($data));
        break;
    case 'update_product':
        $pid = (int)($_POST['product_id'] ?? 0);
        $data = [
            'cat_id' => (int)($_POST['cat_id'] ?? 0),
            'brand_id' => (int)($_POST['brand_id'] ?? 0),
            'title' => trim($_POST['title'] ?? ''),
            'price' => (float)($_POST['price'] ?? 0),
            'description' => trim($_POST['description'] ?? ''),
            'image_path' => trim($_POST['image_path'] ?? null),
            'keywords' => trim($_POST['keywords'] ?? null)
        ];
        echo json_encode(update_product_ctr($pid, $data));
        break;
    default:
        echo json_encode(['status'=>'error','message'=>'Unknown action']);
}
