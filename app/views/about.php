<?php
include_once '../parsedown/Parsedown.php';
?>
<?php include 'subview/head.php' ?>
<body>
    <?php include 'subview/navbar.php' ?>
    <div id="main">
        <div id="paste-view-text">
        <?=
            Parsedown::instance()->text("
Certainly! Here’s an updated version of the “About” page that includes the options for creating unlisted or private pastes:

---

# About Pastakanle

Welcome to **Pastakanle**, your ultimate tool for managing, sharing, and securing markdown content with ease.

## What is Pastakanle?

Pastakanle is a versatile service designed to streamline how you handle and share markdown content. Whether you're a developer, writer, or simply a markdown enthusiast, Pastakanle provides a user-friendly platform for pasting, storing, and sharing your markdown snippets.

## Our Mission

Our mission is to simplify your markdown experience with an intuitive interface while ensuring that your content remains secure and private. We aim to offer a solution that balances functionality, ease of use, and top-notch security.

## Key Features

- **Easy Markdown Sharing**: Paste your markdown content and share it via a unique URL. Ideal for collaboration, project sharing, or quick dissemination of information.
- **Secure Storage with End-to-End Encryption**: Opt for end-to-end encryption to keep your content secure. Only you—and those you grant access—can view your encrypted data.
- **Unlisted and Private Pastes**: Choose between creating public, unlisted, or private pastes. Unlisted pastes are accessible only via a direct link, while private pastes require authentication to view.
- **Simple Interface**: Navigate with ease using our clean and straightforward design, tailored for efficient markdown management.

## Security and Privacy

We take your security seriously. With optional end-to-end encryption, your content is safeguarded from unauthorized access. Choose the level of visibility that suits your needs, from public sharing to private and unlisted options, ensuring your data remains under your control.

## Who We Are

Pastakanle was developed by a team of passionate developers and writers dedicated to enhancing the markdown experience. We saw the need for a tool that combines simplicity with advanced security features, and we’re proud to offer that to you.

Thank you for choosing Pastakanle. We’re excited to support your markdown journey with convenience, flexibility, and security!

---

Feel free to make any additional tweaks or adjustments as needed!
            ")
        ?>
        </div>
    </div>
    <script src="/statics/navbar.js"></script>
    <script src="/statics/view.js"></script>
    <?php include 'subview/notif.php' ?>
</body>
</html>