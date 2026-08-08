<?php
/** Work — experience, projects, technologies. */
$c = $data;
?>
<section class="section page-intro">
    <div class="container">
        <p class="eyebrow"><?= e($c['commands']['work']) ?></p>
        <div class="section-head">
            <h2>What I build</h2>
            <span class="section-index mono">software · apps · games</span>
        </div>
    </div>
</section>

<?php require __DIR__ . '/partials/experience.php'; ?>
<?php require __DIR__ . '/partials/projects.php'; ?>
<?php require __DIR__ . '/partials/technologies.php'; ?>