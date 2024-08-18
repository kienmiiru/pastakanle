    <div id="navbar">
        <span><a href="/">Pastakanle</a></span>
        <span><a href="/explore">Explore</a></span>
        <span><a href="/about">About</a></span>

        <div style="margin:0 0 0 auto;cursor:auto;display:flex;">
            <!-- div class="dropdown">
                <span>Theme ▼</span>
                <div class="dropdown-content nodisplay">
                    isi
                </div>
            </div -->
            <?php if (!array_key_exists("username", $_SESSION)) { ?>
            <div class="dropdown">
                <span>Login ▼</span>
                <div class="dropdown-content nodisplay">
                    <div class="login-identity">
                        <label for="login-username">Username:</label>
                        <input type="text" name="username" id="login-username" maxlength="20" autocomplete="username">
                    </div>
                    <div class="login-identity">
                        <label for="login-password">Password:</label>
                        <input type="password" name="password" id="login-password">
                    </div>
                    <div id="login-message" class="nodisplay"></div>
                    <button id="login-button">Login</button>
                    <div>
                        <a href="/register">Click here to register an account</a>
                    </div>
                </div>
            </div>
            <?php } else { ?>
            <div class="dropdown">
                <span><?=$_SESSION["username"]?> ▼</span>
                <div class="dropdown-content nodisplay">
                    <div class="menu-item">
                        <a href="/dashboard">Manage pastes</a>
                    </div>
                    <div class="menu-item">
                        <a href="/password">Change password</a>
                    </div>
                    <div class="menu-item">
                        <button id="logout-button">Logout</button>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <div id="ntf-list">
        </div>
    </div>