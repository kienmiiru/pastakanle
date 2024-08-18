<?php
class LogoutController extends Controller {
    public function post() {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        $result = ['status' => 'success', 'message' => 'Nobody reads this'];
        $_SESSION['flash_info'] = 'You have been logged out';
        echo json_encode($result);
        die();
    }
}
?>
