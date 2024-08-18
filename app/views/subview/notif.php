<?php
        foreach (['info', 'error', 'success'] as $flash) {
            if (isset($_SESSION['flash_' . $flash])) {
                echo '<script>addNotification("'. $flash . '", "' . $_SESSION['flash_' . $flash] . '")</script>';
                unset($_SESSION['flash_' . $flash]);
            }
        }
?>