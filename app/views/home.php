<?php
/** Home — hero with terminal card, ticker, focus, about, experience, projects, technologies. */
$c = $data;
$tickerItems = array_merge($c['ticker'], $c['languages'], $c['frameworks']);
?>
<section class="hero">
    <div class="container">
        <div class="hero-grid">
            <div class="hero-copy" data-reveal>
                <p class="eyebrow"><?= e($c['commands']['hero']) ?></p>

                <h1 data-type><?= e($c['name']) ?><span class="type-caret" aria-hidden="true"></span></h1>

                <p class="hero-role"><?= e($c['role']) ?></p>

                <p class="lead"><?= e($c['tagline']) ?></p>

                <div class="btn-row">
                    <a class="btn btn--primary" href="/work">View my work</a>
                    <a class="btn btn--ghost" href="/contact">Get in touch</a>
                </div>

                <div class="hero-foot">
                    <?php if (!empty($c['available'])): ?>
                        <span><span class="pulse" aria-hidden="true"></span><?= e($c['availability']) ?></span>
                    <?php endif; ?>
                    <span><?= e($c['location']) ?></span>
                    <span>Third-year · B.S. Computer Science</span>
                </div>
            </div>

            <aside class="hero-aside">
                <?php
                $slot = $c['images']['avatar'];
                $slotAlt = 'Nash Bruce Quiros';
                $slotClass = 'img-slot img-slot--portrait';
                require __DIR__ . '/partials/image-slot.php';
                unset($slot, $slotAlt, $slotClass);
                ?>

                <div class="term" data-reveal>
                    <div class="term-bar">
                        <span class="term-dot term-dot--danger" aria-hidden="true"></span>
                        <span class="term-dot term-dot--accent" aria-hidden="true"></span>
                        <span class="term-dot term-dot--muted" aria-hidden="true"></span>
                        <span class="term-title mono">nash@portfolio — profile</span>
                    </div>
                    <div class="term-body">
                        <dl class="profile">
                            <div class="profile-row">
                                <dt>Name</dt>
                                <dd>Nash Bruce Quiros</dd>
                            </div>
                            <div class="profile-row">
                                <dt>Focus</dt>
                                <dd><?= e(implode(' · ', array_column($c['focus'], 'label'))) ?></dd>
                            </div>
                            <div class="profile-row">
                                <dt>Status</dt>
                                <dd><span class="profile-status" data-cycle='<?= e(json_encode($c['term_cycle'])) ?>'>OPEN TO WORK</span></dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>

<div class="ticker" aria-hidden="true">
    <div class="ticker-inner">
        <div class="ticker-group">
            <?php foreach ($tickerItems as $item): ?>
                <span><?= e($item) ?></span><span class="ticker-sep">▮</span>
            <?php endforeach; ?>
        </div>
        <div class="ticker-group">
            <?php foreach ($tickerItems as $item): ?>
                <span><?= e($item) ?></span><span class="ticker-sep">▮</span>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<section class="section--tight">
    <div class="container">
        <ul class="focus-grid" aria-label="Focus areas">
            <?php foreach ($c['focus'] as $item): ?>
                <li class="focus-item">
                    <span class="focus-label"><?= e($item['label']) ?></span>
                    <span class="focus-detail mono"><?= e($item['detail']) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<section class="section" data-reveal>
    <div class="container">
        <div class="section-head">
            <h2><?= e($c['commands']['about']) ?></h2>
            <span class="section-index mono">student · developer · creator</span>
        </div>
        <?php foreach ($c['home_intro'] as $paragraph): ?>
            <p class="lead" style="max-width: 62ch; margin-bottom: 18px;"><?= e($paragraph) ?></p>
        <?php endforeach; ?>
        <div class="btn-row" style="margin-top: 28px;">
            <a class="btn btn--ghost" href="/about">More about me</a>
        </div>
    </div>
</section>

<?php require __DIR__ . '/partials/experience.php'; ?>
<?php require __DIR__ . '/partials/projects.php'; ?>
<?php require __DIR__ . '/partials/technologies.php'; ?>
