<?php
// classes/product_class.php
require_once(__DIR__ . "/../settings/db_connection.php");

class Product extends DbConnection {

    public function addProduct($data) {
        $sql = "INSERT INTO products (product_cat, product_brand, product_title, product_price, product_desc, product_image, product_keywords)
                VALUES (:product_cat, :product_brand, :product_title, :product_price, :product_desc, :product_image, :product_keywords)";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([
            ':product_cat'=>$data['cat_id'],
            ':product_brand'=>$data['brand_id'],
            ':product_title'=>$data['title'],
            ':product_price'=>$data['price'],
            ':product_desc'=>$data['description'],
            ':product_image'=>$data['image_path'] ?? $data['product_image'] ?? null,
            ':product_keywords'=>$data['keywords'] ?? null
        ]);
    }

    public function updateProduct($product_id, $data) {
        $sql = "UPDATE products SET product_cat=:product_cat, product_brand=:product_brand, product_title=:product_title, product_price=:product_price, product_desc=:product_desc, product_image=:product_image, product_keywords=:product_keywords WHERE product_id=:product_id";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([
            ':product_cat'=>$data['cat_id'],
            ':product_brand'=>$data['brand_id'],
            ':product_title'=>$data['title'],
            ':product_price'=>$data['price'],
            ':product_desc'=>$data['description'],
            ':product_image'=>$data['image_path'] ?? $data['product_image'] ?? null,
            ':product_keywords'=>$data['keywords'] ?? null,
            ':product_id'=>$product_id
        ]);
    }

    public function getAllProducts($limit=null, $offset=null) {
        $sql = "SELECT p.*, c.cat_name, b.brand_name FROM products p
                JOIN categories c ON p.product_cat = c.cat_id
                LEFT JOIN brands b ON p.product_brand = b.brand_id
                ORDER BY p.product_id DESC";
        if ($limit) $sql .= " LIMIT ".(int)$limit. " OFFSET ".(int)$offset;
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($product_id) {
        $sql = "SELECT p.*, c.cat_name, b.brand_name FROM products p
                JOIN categories c ON p.product_cat = c.cat_id
                LEFT JOIN brands b ON p.product_brand = b.brand_id
                WHERE p.product_id = :pid LIMIT 1";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([':pid'=>$product_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function searchProducts($query) {
        $q = "%".$query."%";
        $sql = "SELECT p.*, c.cat_name, b.brand_name FROM products p
                JOIN categories c ON p.product_cat = c.cat_id
                LEFT JOIN brands b ON p.product_brand = b.brand_id
                WHERE p.product_title LIKE :q OR p.product_keywords LIKE :q OR p.product_desc LIKE :q
                ORDER BY p.product_id DESC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([':q'=>$q]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filterByCategory($cat_id) {
        $sql = "SELECT p.*, c.cat_name, b.brand_name FROM products p
                JOIN categories c ON p.product_cat = c.cat_id
                LEFT JOIN brands b ON p.product_brand = b.brand_id
                WHERE p.product_cat = :cid
                ORDER BY p.product_id DESC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([':cid'=>$cat_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filterByBrand($brand_id) {
        $sql = "SELECT p.*, c.cat_name, b.brand_name FROM products p
                JOIN categories c ON p.product_cat = c.cat_id
                LEFT JOIN brands b ON p.product_brand = b.brand_id
                WHERE p.product_brand = :bid
                ORDER BY p.product_id DESC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([':bid'=>$brand_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
