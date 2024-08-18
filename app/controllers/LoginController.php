<?php
class LoginController extends Controller {
    public function post() {
        header('Content-Type: application/json');
        $conditions = [
            isset($_POST['username']) && isset($_POST['password']) &&
            strlen($_POST['username']) >= 4 &&
            preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username']) &&
            strlen($_POST['password']) >= 8
        ];
        foreach ($conditions as $condition) {
            if (!$condition) {
                $result = ['status' => 'error', 'message' => 'Incorrect username or password'];
                echo json_encode($result);
                die();
            }
        }

        $userModel = $this->model('User');

        $user = $userModel->getUserByUsername($_POST['username']);
        if ($user && password_verify($_POST['password'], $user['password'])) {
            if ($user['is_banned']) {
                $result = ['status' => 'error', 'message' => 'Your account is banned'];
                echo json_encode($result);
                die();
            }
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $userModel->updateLastLogin($user['user_id']);
            $result = ['status' => 'success', 'message' => 'You are now logged in'];
            $_SESSION['flash_info'] = 'You are now logged in';
            echo json_encode($result);
            die();
        } else {
            $result = ['status' => 'error', 'message' => 'Incorrect username or password'];
            echo json_encode($result);
            die();
        }
    }
}
?>
