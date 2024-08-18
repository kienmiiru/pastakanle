<?php http_response_code(404); ?>
<?php include 'subview/head.php' ?>
<body>
    <?php include 'subview/navbar.php' ?>
    <div id="main">
        <div id="paste-view-title">Not Found</div>
        <div id="paste-view-text">
            <em>Can't access this page/paste. It may have been deleted, expired, or you don't have access to it.</em><br>
            <em>If you want to view a private paste, or want to edit a paste, please log in to your account.</em><br>
            <em>If you believe this was a mistake, you are wrong.</em><br>
        </div>
    </div>
    <script src="/statics/navbar.js"></script>
    <script src="/statics/view.js"></script>
    <?php include 'subview/notif.php' ?>
</body>
</html>