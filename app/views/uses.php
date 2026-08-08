<?php
/** Uses — the tools and workflow behind the work. */
$c = $data;
?>
<section class="section page-intro">
    <div class="container">
        <p class="eyebrow">Uses</p>
        <div class="section-head">
            <h1 class="page-title">The stack I<br>actually use.</h1>
            <span class="section-index mono">tools · workflow</span>
        </div>
        <p class="lead" style="max-width: 60ch;"><?= e($c['uses_intro']) ?></p>
    </div>
</section>

<section class="section" data-reveal>
    <div class="container">
        <div class="uses-grid">
            <?php foreach ($c['uses'] as $category => $items): ?>
                <div class="uses-col">
                    <h2 class="uses-cat mono"><?= e($category) ?></h2>
                    <ul class="uses-list">
                        <?php foreach ($items as $item): ?>
                            <li><?= e($item) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section" data-reveal>
    <div class="container">
        <div class="section-head">
            <h2><?= e($c['commands']['build']) ?></h2>
            <span class="section-index mono">how I work</span>
        </div>
        <div class="workflow">
            <?php foreach ($c['workflow'] as $i => $w): ?>
                <div class="principle">
                    <span class="p-num">/0<?= $i + 1 ?></span>
                    <div>
                        <h3><?= e($w['step']) ?></h3>
                        <p><?= e($w['body']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
