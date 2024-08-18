<?php
class EditController extends Controller {
    public function get($paste_code) {
        if (!isset($paste_code, $_SESSION['user_id'])) {
            $this->view('notfound');
            die();
        }

        $pasteModel = $this->model('paste');
        $paste = $pasteModel->getPasteByPasteCode($paste_code);

        if (
            !$paste ||
            $paste['user_id'] != $_SESSION['user_id']
        ) {
            $this->view('notfound');
            die();
        }

        $data = [
            'paste_code' => $paste['paste_code'],
            'title' => $paste['title'],
            'content' => $paste['content'],
            'visibility' => $paste['visibility']
        ];
        $this->view('edit', $data);
    }

    public function post() {
        $condition = (
            isset($_SESSION['user_id'], $_POST['paste_code'], $_POST['title'], $_POST['text'], $_POST['visibility'], $_POST['expiration']) &&
            $_POST['title'] !== '' &&
            $_POST['text'] !== '' &&
            in_array($_POST['visibility'], ['0', '1', '2']) &&
            in_array($_POST['expiration'], ['-1', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'])
        );

        if (!$condition) {
            $result = ['status' => 'error', 'message' => 'There was an issue with the request'];
            echo json_encode($result);
            die();
        }

        $paste_code = $_POST['paste_code'];
        $title = $_POST['title'];
        $content = $_POST['text'];
        $visibility = $_POST['visibility'];
        $expire_at = $_POST['expiration'];
        $pasteModel = $this->model('Paste');

        $paste = $pasteModel->getPasteByPasteCode($paste_code);
        if (
            !$paste ||
            $paste['user_id'] != $_SESSION['user_id']
        ) {
            $result = ['status' => 'error', 'message' => 'There was an issue with the request'];
            echo json_encode($result);
            die();
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

        if ($expire_at == -1) {
            $expires_at = $paste['expires_at'];
        } elseif ($expire_at == 0) {
            $expires_at = null;
        } else {
            $date = new DateTime();
            $date->add(date_interval_create_from_date_string($expire_options[$expire_at]));
            $expires_at = $date->format('Y-m-d H:i:s');
        }

        $data = [
            'paste_id' => $paste['paste_id'],
            'title' => $title,
            'content' => $content,
            'visibility' => $visibility,
            'expires_at' => $expires_at
        ];
        $response = $pasteModel->updatePaste($data);
        if ($response['status'] == "success") {
            $_SESSION['flash_success'] = $response['message'];
            $result = ['status' => 'success', 'message' => "/$paste_code"];
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
