<?php
namespace App\Backend\Classes;

use App\Backend\Classes\Database;

class Notifier {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->getConnection();
    }

    public function addNotification($message) {
        $stmt = $this->conn->prepare("INSERT INTO notifications (message, is_read) VALUES (?, 0)");
        $stmt->bind_param("s", $message);
        $stmt->execute();
        $stmt->close();
    }

    public function getNotifications() {
        $stmt = $this->conn->prepare("SELECT id, message FROM notifications WHERE is_read = 0");
        $stmt->execute();
        $result = $stmt->get_result();
        $notifications = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $notifications;
    }

    public function markAsRead($id) {
        $stmt = $this->conn->prepare("UPDATE notifications SET is_read = 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}
?>
