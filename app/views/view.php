<?php
include_once '../parsedown/Parsedown.php';
?>
<?php include 'subview/head.php' ?>

<body>
<?php include 'subview/navbar.php' ?>
    <div id="main">
        <div id="paste-view-title"><?= htmlspecialchars($data['title']) ?></div>
        <div id="paste-view-details">
            <div>
                <span title="<?=$data['visibility_text']?>"><?=$data['visibility']?></span> |
                <span>author: <?php
                            if ($data['name']) {
                                echo '<a href="/profile/' . $data['name'] . '">' . $data['name'] . '</a>';
                            } else {
                                echo 'guest';
                            }
                        ?></span> |
                <span title="<?=$data['raw_date']?>">created: <?=$data['date']?></span> |
                <span title="<?=$data['raw_expire']?>">expires: <?=$data['expire'] ?? 'never' ?></span> |
                <span title="<?=$data['raw_edited']?>">last edited: <?=$data['edited'] ?? '-' ?></span>
            </div>
            <div style="margin-left: auto;">
                <?php if ($data['owned']) { ?>
                <a href="/edit/<?= $data['paste_code'] ?>">edit</a>
                <a onclick="deletePaste('<?= $data['paste_code'] ?>')" style="cursor: pointer;">delete</a>
                <?php } ?>
                <?php if ($data['is_encrypted']) { ?>
                <a onclick="decryptPaste(this)" style="cursor: pointer;">decrypt</a>
                <?php } ?>
                <a href="/raw/<?= $data['paste_code'] ?>">raw</a>
            </div>
        </div>
        <div id="paste-view-text">
<?= $data['is_encrypted'] ? $data['content'] : Parsedown::instance()->text($data['content'])?>

        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script src="/statics/navbar.js"></script>
    <script src="/statics/view.js"></script>
    <?php include 'subview/notif.php' ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.10.0/styles/tokyo-night-dark.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.10.0/highlight.min.js"></script>
    <script>hljs.highlightAll();</script>
</body>
</html>