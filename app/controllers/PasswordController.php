<?php
class PasswordController extends Controller {
    public function get() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /");
            die();
        }
        $this->view('password');
    }

    public function post() {
        header('Content-Type: application/json');

        $condition = (
            isset($_SESSION['user_id'], $_POST['old-password'], $_POST['new-password']) &&
            $_POST['old-password'] !== '' &&
            $_POST['new-password'] !== '' &&
            strlen($_POST['old-password']) >= 8 &&
            strlen($_POST['new-password']) >= 8
        );

        if (!$condition) {
            $result = ['status' => 'error', 'message' => '!!!'];
            echo json_encode($result);
            die();
        }

        $userModel = $this->model('User');

        $user = $userModel->getUserById($_SESSION['user_id']);
        if ($user['password'] == md5($_POST['old-password'])) {
            $userModel->updatePassword($user['user_id'], $_POST['new-password']);
            $result = ['status' => 'success', 'message' => 'Password successfully changed'];
            $_SESSION['flash_success'] = 'Password successfully changed';
            echo json_encode($result);
            die();
        } else {
            $result = ['status' => 'error', 'message' => 'Incorrect password'];
            echo json_encode($result);
            die();
        }
    }
}
?>
