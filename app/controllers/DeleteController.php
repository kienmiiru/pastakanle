<?php
class DeleteController extends Controller {
    public function post() {
        $condition = (
            isset($_SESSION['user_id'], $_POST['paste_code'])
        );

        if (!$condition) {
            $result = ['status' => 'error', 'message' => 'There was an issue with the request'];
            echo json_encode($result);
            die();
        }

        $paste_code = $_POST['paste_code'];
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

        $response = $pasteModel->deletePaste($paste['paste_id']);
        if ($response['status'] == "success") {
            $_SESSION['flash_success'] = $response['message'];
            $result = ['status' => 'success', 'message' => 'Nobody reads this'];
            echo json_encode($result);
            die();
        }
    }
}
?>
