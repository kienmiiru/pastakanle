<?php

class User extends Model {
    public function createUser($data) {
        try {
            $username = $data['username'];
            $password = password_hash($data['password'], PASSWORD_DEFAULT);
    
            $stmt = $this->db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    
            $stmt->execute();
    
            return true;
        } catch (PDOException $e) {
            throw new Exception("Database update failed: " . $e->getMessage());
        }
    }

    public function getUserById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ?: null;
        } catch (PDOException $e) {
            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }

    public function getUserByUsername($username) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE LOWER(username) = LOWER(:username)");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ?: null;
        } catch (PDOException $e) {
            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }

    public function updateLastLogin($user_id) {
        try {
            $stmt = $this->db->prepare("UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Database update failed: " . $e->getMessage());
        }
    }

    public function updatePassword($user_id, $password) {
        try {
            $stmt = $this->db->prepare("UPDATE users SET password = :password WHERE user_id = :user_id");
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount(); 
        } catch (PDOException $e) {
            throw new Exception("Database update failed: " . $e->getMessage());
        }
    }

    public function updateUsername($user_id, $username) {
        try {
            $stmt = $this->db->prepare("UPDATE users SET username = :username WHERE user_id = :user_id");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount(); 
        } catch (PDOException $e) {
            throw new Exception("Database update failed: " . $e->getMessage());
        }
    }
}
?>
