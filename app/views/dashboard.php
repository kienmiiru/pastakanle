<?php include 'subview/head.php' ?>
<body>
    <?php include 'subview/navbar.php' ?>
    <div id="main">
        <div id="paste-view-title">Your pastes</div>
        <table id="paste-list">
            <thead>
                <tr>
                    <th></th>
                    <th>Code</th>
                    <th>Title</th>
                    <th>Created</th>
                    <th>Expires</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['pastes'] as $paste) { ?>
                <tr>
                    <td><?= $paste['visibility'] ?></td>
                    <td><a href="/<?= $paste['code'] ?>"><?= $paste['code'] ?></a></td>
                    <td><a href="/<?= $paste['code'] ?>"><?= $paste['title'] ?></a></td>
                    <td><span title="<?=$paste['raw_date']?>"><?=$paste['date']?></span></td>
                    <td><span title="<?=$paste['raw_expire']?>"><?=$paste['expire'] ?? 'never' ?></span></td>
                    <td>
                        <a style="font-size:24px;color:inherit;text-decoration:inherit;" title="Edit" href="/edit/<?= $paste['code'] ?>">🖉</a>
                        <span style="cursor:pointer;font-size:24px;" title="Delete" onclick="deletePaste('<?= $paste['code'] ?>')">🗑</span>
                    </td>
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
    <script src="/statics/dashboard.js"></script>
    <?php include 'subview/notif.php' ?>
</body>
</html>