<?php
class RegisterController extends Controller {
    public function get() {
        if (isset($_SESSION['user_id'])) {
            header("Location: /dashboard");
            die();
        }
        $this->view('register');
    }

    public function post() {
        if (isset($_SESSION['user_id'])) {
            die();
        }

        $condition = 
            isset($_POST['username']) && isset($_POST['password']) &&
            strlen($_POST['username']) >= 4 && strlen($_POST['username']) <= 20 &&
            preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username']) &&
            strlen($_POST['password']) >= 8;

        if (!$condition) {
            $result = ['status' => 'error', 'message' => 'There was an issue with the request'];
            echo json_encode($result);
            die();
        }

        $userModel = $this->model('User');

        $user_exists = $userModel->getUserByUsername($_POST['username']);
        if ($user_exists) {
            $result = ['status' => 'error', 'message' => 'Sorry, this username is taken'];
            echo json_encode($result);
            die();
        }

        $userModel->createUser($_POST);
        $_SESSION['flash_success'] = 'Registration success! You can now login';
        $result = ['status' => 'success', 'message' => '?success'];
        echo json_encode($result);
        die();
    }
}
?>
