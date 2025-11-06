<?php
// classes/customer_class.php
require_once(__DIR__ . "/../settings/db_connection.php");

class Customer extends DbConnection {

    /**
     * Add a new customer. Maps incoming fields to the `customer` table defined in shoppn.sql.
     * Expects: full name, email, plain password, country, city, contact number, optional user_role
     */
    public function addCustomer($full_name, $email, $password, $country, $city, $contact_number, $user_role = 2, $image = null) {
        $sql = "INSERT INTO customer (customer_name, customer_email, customer_pass, customer_country, customer_city, customer_contact, customer_image, user_role)
                VALUES (:customer_name, :customer_email, :customer_pass, :customer_country, :customer_city, :customer_contact, :customer_image, :user_role)";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([
            ':customer_name' => $full_name,
            ':customer_email' => $email,
            ':customer_pass' => password_hash($password, PASSWORD_BCRYPT),
            ':customer_country' => $country,
            ':customer_city' => $city,
            ':customer_contact' => $contact_number,
            ':customer_image' => $image,
            ':user_role' => $user_role
        ]);
    }

    /**
     * Check if an email already exists in the `customer` table.
     * Returns the row if found, false/null otherwise.
     */
    public function checkEmail($email) {
        $sql = "SELECT * FROM customer WHERE customer_email = :email LIMIT 1";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get a customer by email (used for login)
     */
    public function getCustomerByEmail($email) {
        $sql = "SELECT * FROM customer WHERE customer_email = :email LIMIT 1";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Verify password for a given email; returns an array with ok flag and either user or reason
     */
    public function verifyPassword($email, $password): array {
        $user = $this->getCustomerByEmail($email);
        if (!$user) {
            return ['ok' => false, 'reason' => 'not_found'];
        }
        if (password_verify($password, $user['customer_pass'])) {
            return ['ok' => true, 'user' => $user];
        }
        return ['ok' => false, 'reason' => 'invalid_password'];
    }
}
