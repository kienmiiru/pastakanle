<?php
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

class NewpasteController extends Controller {
    public function post() {
        $condition = (
            isset($_POST['title']) && isset($_POST['text']) && isset($_POST['visibility']) && isset($_POST['expiration']) &&
            $_POST['title'] !== '' &&
            $_POST['text'] !== '' &&
            in_array($_POST['visibility'], ['0', '1', '2']) &&
            in_array($_POST['expiration'], ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9']) &&
            ($_POST['visibility'] != '2' || isset($_SESSION['user_id']))
        );

        if (!$condition) {
            $result = ['status' => 'error', 'message' => 'There was an issue with the request'];
            echo json_encode($result);
            die();
        }

        $paste_code = generateRandomString(5);
        $title = $_POST['title'];
        $content = $_POST['text'];
        $visibility = $_POST['visibility'];
        $expire_at = $_POST['expiration'];
        $pasteModel = $this->model('Paste');

        $paste_exist = $pasteModel->getPasteByPasteCode($paste_code);
        while ($paste_exist) {
            $paste_code = generateRandomString(5);
            $paste_exist = $pasteModel->getPasteByPasteCode($paste_code);
        }

        $expire_options = [
            '',
            '10 minutes',
            '1 hour',
            '1 day',
            '1 week',
            '2 weeks',
            '1 month',
            '6 months',
            '1 year',
        ];

        if ($expire_at == 0) {
            $expires_at = null;
        } else {
            $date = new DateTime();
            $date->add(date_interval_create_from_date_string($expire_options[$expire_at]));
            $expires_at = $date->format('Y-m-d H:i:s');
        }

        $data = [
            'paste_code' => $paste_code,
            'title' => $title,
            'content' => $content,
            'user_id' => $_SESSION['user_id'] ?? null,
            'visibility' => $visibility,
            'expires_at' => $expires_at
        ];
        $response = $pasteModel->createPaste($data);
        if ($response['status'] == "success") {
            $result = ['status' => 'success', 'message' => "/$paste_code"];
            $_SESSION['flash_info'] = 'Your paste has been created';
            echo json_encode($result);
            die();
        } else {
            $result = ['status' => 'error', 'message' => 'Something went wrong'];
            echo json_encode($result);
            die();
        }
    }
}
?>
