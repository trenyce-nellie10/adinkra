<?php
// classes/brand_class.php
require_once(__DIR__ . "/../settings/db_connection.php");

class Brand extends DbConnection {

    /**
     * Returns all brands from the `brands` table. The schema (shoppn.sql) only defines
     * `brand_id` and `brand_name` for brands, so we keep operations simple.
     */
    public function getAllBrands() {
        $sql = "SELECT * FROM brands ORDER BY brand_name";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Add a brand (only brand_name is stored per schema). */
    public function addBrand($brand_name) {
        $sql = "INSERT INTO brands (brand_name) VALUES (:brand_name)";
        $stmt = $this->connect()->prepare($sql);
        try {
            return $stmt->execute([':brand_name'=>$brand_name]);
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
}

