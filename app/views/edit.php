<?php include 'subview/head.php' ?>
<body>
<?php include 'subview/navbar.php' ?>
    <form id="main">
        Editing:
        <input type="hidden" name="paste_code" value="<?=htmlspecialchars($data['paste_code'])?>">
        <input type="text" name="title" id="paste-title" placeholder="title..." maxlength="100" value="<?=htmlspecialchars($data['title'])?>">
        <textarea name="text" id="paste-text" maxlength="200000"><?=$data['content']?></textarea>
        <div id="char-limit">0/200,000</div>
        <div id="char-limit-encrypted" class="nodisplay">Encrypted: 0/200,000</div>
        <div id="messages" class="nodisplay"></div>
        <div class="option">
            <span>Visibility:</span>
            <div>
                <input type="radio" name="visibility" id="paste-visibility-0" value="0" <?= $data['visibility'] == '0' ? 'checked' : '' ?>>
                <label title="Anyone with the link can see this" for="paste-visibility-0">Unlisted</label>
                <input type="radio" name="visibility" id="paste-visibility-1" value="1" <?= $data['visibility'] == '1' ? 'checked' : '' ?>>
                <label title="Available to anyone in this site" for="paste-visibility-1">Public</label>
                <input type="radio" name="visibility" id="paste-visibility-2" value="2" <?= $data['visibility'] == '2' ? 'checked' : '' ?>>
                <label title="Only you (the owner) can see this" for="paste-visibility-2">Private</label>
            </div>
        </div>
        <div class="option">
            <label for="paste-encryption-key">Encryption:</label>
            <div>
                <input type="radio" name="paste-encryption" id="paste-encryption-disable" value="0" checked>
                <label for="paste-encryption-disable">Off</label>
                <input type="radio" name="paste-encryption" id="paste-encryption-enable" value="1">
                <label for="paste-encryption-enable">On</label>
                <input disabled name="encryption-key" id="paste-encryption-key">
            </div>
        </div>
        <div class="option">
            <span>Expiration:</span>
            <div>
                <input type="radio" name="expiration" id="paste-expiration--1" value="-1" checked>
                <label for="paste-expiration--1">Don't change</label>
                <input type="radio" name="expiration" id="paste-expiration-0" value="0">
                <label for="paste-expiration-0">Never</label>
                <input type="radio" name="expiration" id="paste-expiration-1" value="1">
                <label for="paste-expiration-1">10 min</label>
                <input type="radio" name="expiration" id="paste-expiration-2" value="2">
                <label for="paste-expiration-2">1 hr</label>
                <input type="radio" name="expiration" id="paste-expiration-3" value="3">
                <label for="paste-expiration-3">1 day</label>
                <input type="radio" name="expiration" id="paste-expiration-4" value="4">
                <label for="paste-expiration-4">1 w</label>
                <input type="radio" name="expiration" id="paste-expiration-5" value="5">
                <label for="paste-expiration-5">2 w</label>
                <input type="radio" name="expiration" id="paste-expiration-6" value="6">
                <label for="paste-expiration-6">1 mo</label>
                <input type="radio" name="expiration" id="paste-expiration-7" value="7">
                <label for="paste-expiration-7">6 mo</label>
                <input type="radio" name="expiration" id="paste-expiration-8" value="8">
                <label for="paste-expiration-8">1 yr</label>
            </div>
        </div>
        <div class="option">
            <div>
                <a class="a-button" href="/<?= $data['paste_code'] ?>">Cancel</a>
                <button id="edit">Edit</button>
                <!--button id="preview">Preview</button-->
            </div>
        </div>
    </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script src="/statics/navbar.js"></script>
    <script src="/statics/edit.js"></script>
</body>
</html>