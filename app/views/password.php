<!DOCTYPE html>
<?php include 'subview/head.php' ?>
<body>
<?php include 'subview/navbar.php' ?>
    <div id="main">
        Change your password
        <form method="post">
            <div class="login-identity">
                <label for="old-password">Current password:</label>
                <input type="password" name="old-password" id="old-password" autocomplete="current-password">
            </div>
            <div class="login-identity">
                <label for="new-password">New password:</label>
                <input type="password" name="new-password" id="new-password" autocomplete="new-password">
            </div>
            <div class="login-identity">
                <label for="verify-password">Verify Password:</label>
                <input type="password" name="verify-password" id="verify-password" autocomplete="new-password">
            </div>
            <div id="messages" class=""></div>
            <button id="change">Change</button>
        </form>
    </div>
    <script src="/statics/navbar.js"></script>
    <script src="/statics/password.js"></script>
    <?php include 'subview/notif.php' ?>
</body>
</html>