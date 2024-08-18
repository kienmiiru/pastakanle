<?php
class ExploreController extends Controller {
    public function get() {
        $pasteModel = $this->model('Paste');
        $pasteCount = $pasteModel->getPublicPastesCount();
        $total_pages = ceil($pasteCount['total'] / 10);

        $_GET['page'] = (!isset($_GET['page']) || !is_numeric($_GET['page'])) ? 1 : $_GET['page'];
        $_GET['page'] = max(1, min($_GET['page'], $total_pages));

        $pastes = $pasteModel->getPublicPastes($_GET['page']);
        $data = ['page_count' => $total_pages, 'pastes' => []];

        foreach($pastes as $paste) {
            $date = human_readable_time_diff((new DateTime())->format('Y-m-d H:i:s'), $paste['date_created']);

            $data['pastes'][] = [
                'visibility' => ['🔗', '🌎', '🔒'][$paste['visibility']],
                'code' => $paste['paste_code'],
                'title' => $paste['title'],
                'author' => $paste['author'] ?? NULL,
                'date' => $date,
                'raw_date' => $paste['date_created']
            ];
        }

        $this->view('explore', $data);
    }
}
?>
