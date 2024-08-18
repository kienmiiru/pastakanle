<?php
class ViewController extends Controller {
    public function get($paste_code) {
        if (!isset($paste_code)) {
            $this->view('notfound');
            die();
        }

        $pasteModel = $this->model('paste');
        $userModel = $this->model('user');
        $paste = $pasteModel->getPasteByPasteCode($paste_code);

        if (
            !$paste ||
            ($paste['visibility'] == 2 && $paste['user_id'] != ($_SESSION['user_id'] ?? null))
        ) {
            $this->view('notfound');
            die();
        }

        $paste_author = $paste['user_id'] ? $userModel->getUserById($paste['user_id']) : null;
        $date = human_readable_time_diff((new DateTime())->format('Y-m-d H:i:s'), $paste['date_created']);
        $expire = $paste['expires_at'] ? human_readable_time_diff((new DateTime())->format('Y-m-d H:i:s'), $paste['expires_at']) : NULL;
        $edited = $paste['last_edited'] ? human_readable_time_diff((new DateTime())->format('Y-m-d H:i:s'), $paste['last_edited']) : NULL;

        $data = [
            'paste_code' => $paste_code,
            'title' => $paste['title'],
            'visibility' => ['🔗', '🌎', '🔒'][$paste['visibility']],
            'visibility_text' => ['Anyone with the link can see this', 'Available to anyone in this site', 'Only you (the owner) can see this'][$paste['visibility']],
            'name' => $paste_author ? $paste_author['username'] : NULL,
            'date' => $date,
            'raw_date' => $paste['date_created'],
            'expire' => $expire,
            'raw_expire' => $paste['expires_at'],
            'edited' => $edited,
            'raw_edited' => $paste['last_edited'],
            'content' => $paste['content'],
            'owned' => isset($_SESSION['user_id']) && $paste['user_id'] == $_SESSION['user_id'],
            'is_encrypted' => preg_match("/^[a-z0-9]{64}U2FsdGVkX1[A-Za-z0-9\+\/\=]+$/", $paste['content'])
        ];
        $this->view('view', $data);
    }
}
?>
