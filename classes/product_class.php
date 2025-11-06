<?php
// classes/product_class.php
require_once(__DIR__ . "/../db/db_connection.php");

class Product extends DbConnection {

    public function addProduct($data) {
        $sql = "INSERT INTO products (cat_id, brand_id, title, price, description, image_path, keywords, user_id)
                VALUES (:cat_id, :brand_id, :title, :price, :description, :image_path, :keywords, :user_id)";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([
            ':cat_id'=>$data['cat_id'],
            ':brand_id'=>$data['brand_id'],
            ':title'=>$data['title'],
            ':price'=>$data['price'],
            ':description'=>$data['description'],
            ':image_path'=>$data['image_path'] ?? null,
            ':keywords'=>$data['keywords'] ?? null,
            ':user_id'=>$data['user_id'] ?? null
        ]);
    }

    public function updateProduct($product_id, $data) {
        $sql = "UPDATE products SET cat_id=:cat_id, brand_id=:brand_id, title=:title, price=:price, description=:description, image_path=:image_path, keywords=:keywords WHERE product_id=:product_id";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([
            ':cat_id'=>$data['cat_id'],
            ':brand_id'=>$data['brand_id'],
            ':title'=>$data['title'],
            ':price'=>$data['price'],
            ':description'=>$data['description'],
            ':image_path'=>$data['image_path'] ?? null,
            ':keywords'=>$data['keywords'] ?? null,
            ':product_id'=>$product_id
        ]);
    }

    public function getAllProducts($limit=null, $offset=null) {
        $sql = "SELECT p.*, c.cat_name, b.brand_name FROM products p
                JOIN categories c ON p.cat_id = c.cat_id
                LEFT JOIN brands b ON p.brand_id = b.brand_id
                ORDER BY p.created_at DESC";
        if ($limit) $sql .= " LIMIT ".(int)$limit. " OFFSET ".(int)$offset;
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($product_id) {
        $sql = "SELECT p.*, c.cat_name, b.brand_name FROM products p
                JOIN categories c ON p.cat_id = c.cat_id
                LEFT JOIN brands b ON p.brand_id = b.brand_id
                WHERE p.product_id = :pid LIMIT 1";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([':pid'=>$product_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function searchProducts($query) {
        $q = "%".$query."%";
        $sql = "SELECT p.*, c.cat_name, b.brand_name FROM products p
                JOIN categories c ON p.cat_id = c.cat_id
                LEFT JOIN brands b ON p.brand_id = b.brand_id
                WHERE p.title LIKE :q OR p.keywords LIKE :q OR p.description LIKE :q
                ORDER BY p.created_at DESC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([':q'=>$q]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filterByCategory($cat_id) {
        $sql = "SELECT p.*, c.cat_name, b.brand_name FROM products p
                JOIN categories c ON p.cat_id = c.cat_id
                LEFT JOIN brands b ON p.brand_id = b.brand_id
                WHERE p.cat_id = :cid
                ORDER BY p.created_at DESC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([':cid'=>$cat_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filterByBrand($brand_id) {
        $sql = "SELECT p.*, c.cat_name, b.brand_name FROM products p
                JOIN categories c ON p.cat_id = c.cat_id
                LEFT JOIN brands b ON p.brand_id = b.brand_id
                WHERE p.brand_id = :bid
                ORDER BY p.created_at DESC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([':bid'=>$brand_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
