<?php function pagination($current_page, $last_page) { ?>
        <div id="pagination">
            <a href="?page=1" <?= $current_page == 1 ? 'class="page-disabled"' : '' ?>><<</a>
            <a href="?page=<?= $current_page - 1 ?>" <?= $current_page == 1 ? 'class="page-disabled"' : '' ?>><</a>

            <?php
            for ($i = $current_page - 5; $i <= $current_page + 5; $i++) {
                if ($i < 1 || $i > $last_page) continue;
                echo '<a href="?page=' . $i . '"' . ($i == $current_page ? 'class="page-current"' : '') . '>' . $i . '</a>';
            } ?>

            <a href="?page=<?= $current_page + 1 ?>" <?= $current_page >= $last_page ? 'class="page-disabled"' : '' ?>>></a>
            <a href="?page=<?= $last_page ?>" <?= $current_page >= $last_page ? 'class="page-disabled"' : '' ?>>>></a>
        </div>
<?php } ?>