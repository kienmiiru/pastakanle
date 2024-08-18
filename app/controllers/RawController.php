<?php
class RawController extends Controller {
    public function get($paste_code) {
        header('Content-Type: text/plain');
        if (!isset($paste_code)) {
            http_response_code(404);
            echo 'not found';
            die();
        }

        $pasteModel = $this->model('paste');
        $paste = $pasteModel->getPasteByPasteCode($paste_code);

        if (
            !$paste ||
            ($paste['visibility'] == 2 && $paste['user_id'] != ($_SESSION['user_id'] ?? null))
        ) {
            http_response_code(404);
            echo 'not found';
            die();
        }

        echo $paste['content'];
    }
}
?>
