<?php include 'subview/head.php' ?>
<body>
    <?php include 'subview/navbar.php' ?>
    <div id="main">
        <div id="paste-view-title"><?= $data['username'] ?>'s pastes</div>
        <table id="paste-list">
            <thead>
                <tr>
                    <th></th>
                    <th>Title</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['pastes'] as $paste) { ?>
                <tr>
                    <td><?= $paste['visibility'] ?></td>
                    <td><a href="/<?= $paste['code'] ?>"><?= htmlspecialchars($paste['title']) ?></a></td>
                    <td><span title="<?=$paste['raw_date']?>"><?=$paste['date']?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
        include_once 'subview/pagination.php';
        pagination($_GET['page'], $data['page_count']);
        ?>
    </div>
    <script src="/statics/navbar.js"></script>
    <?php include 'subview/notif.php' ?>
</body>
</html>