<?php include 'subview/head.php' ?>
<body>
<?php include 'subview/navbar.php' ?>
    <div id="main">
        Register a new account
        <form method="post">
            <div class="login-identity">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" maxlength="20">
            </div>
            <div class="login-identity">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password">
            </div>
            <div class="login-identity">
                <label for="verify-password">Verify Password:</label>
                <input type="password" name="verify-password" id="verify-password">
            </div>
            <?php if (array_key_exists("success", $_GET)) echo "<div id=\"info\">Registration success! You can now login</div>\n" ?>
            <?php if (array_key_exists("taken", $_GET)) echo "<div id=\"info\">Sorry, this username is taken!</div>\n" ?>
            <?php if (array_key_exists("error", $_GET)) echo "<div id=\"info\">Something went wrong</div>\n" ?>
            <?php if (array_key_exists("ir", $_GET)) echo "<div id=\"info\">Invalid request</div>\n" ?>
            <div id="messages" class=""></div>
            <button id="register">Register</button>
        </form>
    </div>
    <script src="/statics/navbar.js"></script>
    <script src="/statics/register.js"></script>
    <?php include 'subview/notif.php' ?>
</body>
</html>