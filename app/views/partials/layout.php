<?php
/**
 * Layout shell. Consumes: $pageTitle, $viewContent, $req, $data.
 */
$name    = $data['name'];
$initials = preg_replace('/[^A-Z]/', '', $name);
$initials = $initials === '' ? 'AC' : substr($initials, 0, 2);
$pageDesc = $data['tagline'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle ?? $name) ?></title>
    <meta name="description" content="<?= e($name) ?> — <?= e($data['role']) ?>. <?= e($pageDesc) ?>">
    <meta name="theme-color" content="#0a0d0a">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@500;600;700&family=Inter:wght@400;500;600&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' rx='7' fill='%2339ff88'/%3E%3Ctext x='16' y='22' font-family='Arial' font-size='17' font-weight='700' text-anchor='middle' fill='%230a0d0a'%3E<?= e($initials) ?>%3C/text%3E%3C/svg%3E">
    <script>
      // Apply the saved accent theme before first paint (no flash).
      (function () {
        try {
          var t = localStorage.getItem('accent-theme');
          if (t === 'amber-v2') { document.documentElement.setAttribute('data-theme', 'amber'); }
        } catch (e) {}
      })();
    </script>

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
    </div>

    <a class="skip-link" href="#main">Skip to content</a>

    <?php require __DIR__ . '/header.php'; ?>

    <main id="main">
        <?= $viewContent ?>
    </main>

    <?php require __DIR__ . '/footer.php'; ?>

    <script src="/assets/js/main.js" defer></script>
</body>
</html>