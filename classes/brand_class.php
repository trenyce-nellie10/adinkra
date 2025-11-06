<?php
// classes/brand_class.php
require_once(__DIR__ . "/../db_connection.php");

class Brand extends DbConnection {

    public function getBrandsByUser($user_id = null) {
        $sql = "SELECT b.*, c.cat_name FROM brands b
                JOIN categories c ON b.cat_id = c.cat_id
                WHERE (:uid IS NULL OR b.user_id = :uid)
                ORDER BY c.cat_name, b.brand_name";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([':uid' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addBrand($brand_name, $cat_id, $user_id = null) {
        $sql = "INSERT INTO brands (brand_name, cat_id, user_id) VALUES (:brand_name, :cat_id, :user_id)";
        $stmt = $this->connect()->prepare($sql);
        try {
            return $stmt->execute([':brand_name'=>$brand_name, ':cat_id'=>$cat_id, ':user_id'=>$user_id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updateBrand($brand_id, $brand_name) {
        $sql = "UPDATE brands SET brand_name = :brand_name WHERE brand_id = :brand_id";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([':brand_name'=>$brand_name, ':brand_id'=>$brand_id]);
    }

    public function deleteBrand($brand_id) {
        $sql = "DELETE FROM brands WHERE brand_id = :brand_id";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([':brand_id'=>$brand_id]);
    }

    public function getBrandById($brand_id) {
        $sql = "SELECT * FROM brands WHERE brand_id = :brand_id LIMIT 1";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([':brand_id'=>$brand_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getBrandsByCategory($cat_id) {
        $sql = "SELECT * FROM brands WHERE cat_id = :cat_id ORDER BY brand_name";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([':cat_id'=>$cat_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

