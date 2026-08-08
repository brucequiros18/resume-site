<?php
/** About — story, facts, principles, expertise, technologies. */
$c = $data;
?>
<section class="section">
    <div class="container">
        <p class="eyebrow"><?= e($c['commands']['about']) ?></p>

        <div class="about-grid">
            <div class="about-copy">
                <h1 class="page-title" style="margin-bottom: 26px;">The future, built<br>one project at a time.</h1>
                <?php foreach ($c['about_story'] as $paragraph): ?>
                    <p><?= e($paragraph) ?></p>
                <?php endforeach; ?>
            </div>

            <div class="about-side">
                <?php
                $slot = $c['images']['about'];
                $slotAlt = 'Nash Bruce Quiros';
                $slotClass = 'img-slot img-slot--portrait';
                require __DIR__ . '/partials/image-slot.php';
                unset($slot, $slotAlt, $slotClass);
                ?>

                <aside class="facts" aria-label="Quick facts">
                    <h3><?= e($c['commands']['facts']) ?></h3>
                <dl>
                    <?php foreach ($c['facts'] as $k => $v): ?>
                        <div class="fact-row">
                            <dt><?= e($k) ?></dt>
                            <dd><?= e($v) ?></dd>
                        </div>
                    <?php endforeach; ?>
                </dl>
            </aside>
        </div>
    </div>

        <div class="principles">
            <div class="section-head" style="margin-bottom: 10px;">
                <h2><?= e($c['commands']['build']) ?></h2>
            </div>

            <?php foreach ($c['principles'] as $i => $principle): ?>
                <div class="principle">
                    <span class="p-num">/0<?= $i + 1 ?></span>
                    <div>
                        <h3><?= e($principle['title']) ?></h3>
                        <p><?= e($principle['body']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="principles">
            <div class="section-head" style="margin-bottom: 10px;">
                <h2><?= e($c['commands']['expertise']) ?></h2>
            </div>

            <ul class="expertise-list">
                <?php foreach ($c['expertise'] as $i => $area): ?>
                    <li>
                        <span class="p-num">/0<?= $i + 1 ?></span>
                        <span><?= e($area) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <?php $embedded = true; ?>
        <?php require __DIR__ . '/partials/technologies.php'; ?>
    </div>
</section>