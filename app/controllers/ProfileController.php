<?php
class ProfileController extends Controller {
    public function get($username = '') {
        if (!isset($username) || ($username == '')) {
            header("Location: /");
            die();
        }


        $userModel = $this->model('User');
        $user = $userModel->getUserByUsername($username);
        if (!$user) {
            $this->view('notfound');
            die();
        }

        $pasteModel = $this->model('Paste');
        $pasteCount = $pasteModel->getPublicPastesByUserIdCount($user['user_id']);
        $total_pages = ceil($pasteCount['total'] / 10);

        $_GET['page'] = (!isset($_GET['page']) || !is_numeric($_GET['page'])) ? 1 : $_GET['page'];
        $_GET['page'] = max(1, min($_GET['page'], $total_pages));

        $pastes = $pasteModel->getPublicPastesByUserId($user['user_id'], $_GET['page']);
        $data = ['username' => $username, 'page_count' => $total_pages, 'pastes' => []];

        foreach($pastes as $paste) {
            $date = human_readable_time_diff((new DateTime())->format('Y-m-d H:i:s'), $paste['date_created']);

            $data['pastes'][] = [
                'visibility' => ['🔗', '🌎', '🔒'][$paste['visibility']],
                'code' => $paste['paste_code'],
                'title' => $paste['title'],
                'date' => $date,
                'raw_date' => $paste['date_created']
            ];
        }

        $this->view('profile', $data);
    }
}
?>
