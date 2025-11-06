<?php
// classes/customer_class.php
require_once("../db/db_connection.php");

class Customer extends DbConnection {

    // EXISTING addCustomer(...) remains from Part 1

    public function addCustomer($full_name, $email, $password, $country, $city, $contact_number, $user_role = 2) {
        $sql = "INSERT INTO customers (full_name, email, password, country, city, contact_number, user_role)
                VALUES (:full_name, :email, :password, :country, :city, :contact_number, :user_role)";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([
            ':full_name' => $full_name,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_BCRYPT),
            ':country' => $country,
            ':city' => $city,
            ':contact_number' => $contact_number,
            ':user_role' => $user_role
        ]);
    }

    public function checkEmail($email) {
        $sql = "SELECT * FROM customers WHERE email = :email LIMIT 1";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /** Get a customer by email (used for login) */
    public function getCustomerByEmail($email) {
        $sql = "SELECT * FROM customers WHERE email = :email LIMIT 1";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /** Verify password for a given email */
    public function verifyPassword($email, $password): array {
        $user = $this->getCustomerByEmail($email);
        if (!$user) {
            return ['ok' => false, 'reason' => 'not_found'];
        }
        if (password_verify($password, $user['password'])) {
            return ['ok' => true, 'user' => $user];
        }
        return ['ok' => false, 'reason' => 'invalid_password'];
    }
}
