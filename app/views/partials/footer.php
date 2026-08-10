<?php
/** Footer — big CTA + meta row. */
?>
<footer class="site-footer">
    <div class="container">
        <div class="footer-cta">
            <p class="eyebrow"><?= e($data['commands']['contact']) ?></p>
            <h2>Let's create something<br>amazing together.</h2>
            <a class="email-link" href="mailto:<?= e($data['email']) ?>"><?= e($data['email']) ?></a>
        </div>

        <div class="footer-bottom">
            <p class="mono">© <?= date('Y') ?> <?= e($data['name']) ?> · <?= e($data['location']) ?></p>
            <div class="socials">
                <?php require __DIR__ . '/socials.php'; ?>
            </div>
        </div>
    </div>
</footer>