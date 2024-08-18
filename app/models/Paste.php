<?php

class Paste extends Model {
    public function createPaste($data) {
        try {
            $paste_code = $data['paste_code'];
            $title = $data['title'];
            $content = $data['content'];
            $user_id = $data['user_id'] ?? null;
            $visibility = $data['visibility'];
            $expires_at = $data['expires_at'] ?? null;
    
            $stmt = $this->db->prepare("
                INSERT INTO pastes (paste_code, title, content, user_id, visibility, expires_at)
                VALUES (:paste_code, :title, :content, :user_id, :visibility, :expires_at)
            ");
            
            $stmt->bindParam(':paste_code', $paste_code, PDO::PARAM_STR);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':content', $content, PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':visibility', $visibility, PDO::PARAM_INT);
            $stmt->bindParam(':expires_at', $expires_at, PDO::PARAM_STR);
    
            $stmt->execute();
    
            return ['status' => 'success', 'message' => 'Paste created successfully'];
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Failed to create paste: ' . $e->getMessage()];
        }
    }

    public function getPasteByPasteCode($paste_code) {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM pastes
                WHERE paste_code = :paste_code
                AND deleted_at IS NULL
                AND (expires_at > NOW() OR expires_at IS NULL)
            ");
            $stmt->bindParam(':paste_code', $paste_code, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Failed to fetch paste: ' . $e->getMessage()];
        }
    }
    
    public function getPublicPastes($page) {
        try {
            $stmt = $this->db->prepare("
                SELECT p.*, u.username AS author
                FROM pastes p
                LEFT JOIN users u ON u.user_id = p.user_id
                WHERE p.visibility = 1
                AND p.deleted_at IS NULL
                AND (p.expires_at > NOW() OR p.expires_at IS NULL)
                ORDER BY p.date_created DESC
                LIMIT 10 OFFSET :offset
            ");
            $offset = ($page - 1) * 10;
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Failed to fetch public pastes: ' . $e->getMessage()];
        }
    }
    
    public function getPublicPastesCount() {
        try {
            $stmt = $this->db->prepare("
                SELECT COUNT(*) AS total
                FROM pastes
                WHERE visibility = 1
                AND deleted_at IS NULL
                AND (expires_at > NOW() OR expires_at IS NULL)
            ");
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Failed to count public pastes: ' . $e->getMessage()];
        }
    }
    
    public function getPastesByUserId($user_id, $page) {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM pastes
                WHERE user_id = :user_id
                AND deleted_at IS NULL
                AND (expires_at > NOW() OR expires_at IS NULL)
                ORDER BY date_created DESC
                LIMIT 10 OFFSET :offset
            ");
            $offset = ($page - 1) * 10;
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Failed to fetch pastes by user ID: ' . $e->getMessage()];
        }
    }
    
    public function getPastesByUserIdCount($user_id) {
        try {
            $stmt = $this->db->prepare("
                SELECT COUNT(*) AS total
                FROM pastes
                WHERE user_id = :user_id
                AND deleted_at IS NULL
                AND (expires_at > NOW() OR expires_at IS NULL)
            ");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Failed to count pastes by user ID: ' . $e->getMessage()];
        }
    }    

    public function getPublicPastesByUserId($user_id, $page) {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM pastes
                WHERE user_id = :user_id
                AND visibility = 1
                AND deleted_at IS NULL
                AND (expires_at > NOW() OR expires_at IS NULL)
                ORDER BY date_created DESC
                LIMIT 10 OFFSET :offset
            ");
            $offset = ($page - 1) * 10;
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Failed to fetch public pastes by user ID: ' . $e->getMessage()];
        }
    }
    
    public function getPublicPastesByUserIdCount($user_id) {
        try {
            $stmt = $this->db->prepare("
                SELECT COUNT(*) AS total
                FROM pastes
                WHERE user_id = :user_id
                AND visibility = 1
                AND deleted_at IS NULL
                AND (expires_at > NOW() OR expires_at IS NULL)
            ");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Failed to count public pastes by user ID: ' . $e->getMessage()];
        }
    }    

    public function updatePaste($data) {
        try {
            $stmt = $this->db->prepare("
                UPDATE pastes
                SET title = :title, content = :content, expires_at = :expires_at, visibility = :visibility, last_edited = NOW()
                WHERE paste_id = :paste_id
            ");
            $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
            $stmt->bindParam(':content', $data['content'], PDO::PARAM_STR);
            $stmt->bindParam(':expires_at', $data['expires_at'], PDO::PARAM_STR);
            $stmt->bindParam(':visibility', $data['visibility'], PDO::PARAM_INT);
            $stmt->bindParam(':paste_id', $data['paste_id'], PDO::PARAM_INT);
            $stmt->execute();
    
            return ['status' => 'success', 'message' => 'Paste successfully edited'];
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Failed to update paste: ' . $e->getMessage()];
        }
    }    

    public function deletePaste($paste_id) {
        try {
            $stmt = $this->db->prepare("
                UPDATE pastes
                SET deleted_at = CURRENT_TIMESTAMP
                WHERE paste_id = :paste_id
            ");
            $stmt->bindParam(':paste_id', $paste_id, PDO::PARAM_INT);
            $stmt->execute();
    
            return ['status' => 'success', 'message' => 'Paste successfully deleted'];
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Failed to delete paste: ' . $e->getMessage()];
        }
    }
    
    public function deleteDeletedPastes() {
        try {
            $query = 'DELETE FROM pastes WHERE deleted_at IS NOT NULL';
            $this->db->exec($query);
    
            return ['status' => 'success', 'message' => 'Deleted pastes deleted successfully'];
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Error deleting deleted pastes: ' . $e->getMessage()];
        }
    }
}
?>
