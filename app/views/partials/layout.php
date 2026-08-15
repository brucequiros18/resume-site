<?php
/**
 * Layout shell. Consumes: $pageTitle, $viewContent, $req, $data.
 */
$name    = $data['name'];
$pageDesc = $data['tagline'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle ?? $name) ?></title>
    <meta name="description" content="<?= e($name) ?> — <?= e($data['role']) ?>. <?= e($pageDesc) ?>">
    <meta name="theme-color" content="#0d0c0a">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@500;600;700&family=Inter:wght@400;500;600&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/images/favicon-192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon-180.png">
</head>
<body>
    <div class="bg" aria-hidden="true">
        <div class="bg-mesh"></div>
        <div class="bg-glow bg-glow--one"></div>
        <div class="bg-glow bg-glow--two"></div>
        <div class="bg-glow bg-glow--three"></div>
        <div class="bg-data bg-data--one"></div>
        <div class="bg-data bg-data--two"></div>
        <div class="bg-floor"></div>
        <div class="bg-shapes" aria-hidden="true">
            <div class="bg-shape bg-shape--far"></div>
            <div class="bg-shape bg-shape--far-b"></div>
            <div class="bg-shape bg-shape--mid"></div>
            <div class="bg-shape bg-shape--near"></div>
        </div>
    </div>

    <a class="skip-link" href="#main">Skip to content</a>

    <?php require __DIR__ . '/header.php'; ?>

    <main id="main">
        <?= $viewContent ?>
    </main>

    <?php require __DIR__ . '/footer.php'; ?>
</body>
</html>