<?php
class DashboardController extends Controller {
    public function get() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /");
            die();
        }

        $pasteModel = $this->model('Paste');
        $pasteCount = $pasteModel->getPastesByUserIdCount($_SESSION['user_id']);
        $total_pages = ceil($pasteCount['total'] / 10);

        $_GET['page'] = (!isset($_GET['page']) || !is_numeric($_GET['page'])) ? 1 : $_GET['page'];
        $_GET['page'] = max(1, min($_GET['page'], $total_pages));

        $pastes = $pasteModel->getPastesByUserId($_SESSION['user_id'], $_GET['page']);
        $data = ['page_count' => $total_pages, 'pastes' => []];

        foreach($pastes as $paste) {
            $date = human_readable_time_diff((new DateTime())->format('Y-m-d H:i:s'), $paste['date_created']);
            $expire = $paste['expires_at'] ? human_readable_time_diff((new DateTime())->format('Y-m-d H:i:s'), $paste['expires_at']) : NULL;

            $data['pastes'][] = [
                'visibility' => ['🔗', '🌎', '🔒'][$paste['visibility']],
                'code' => $paste['paste_code'],
                'title' => $paste['title'],
                'date' => $date,
                'raw_date' => $paste['date_created'],
                'expire' => $expire,
                'raw_expire' => $paste['expires_at'],
            ];
        }

        $this->view('dashboard', $data);
    }
}
?>
