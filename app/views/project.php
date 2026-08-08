<?php
/**
 * Single project detail page.
 * $params['slug'] is provided by the dynamic route /work/{slug}.
 * Unknown slug renders the 404 content with a 404 status.
 */
$c = $data;
$slug = $params['slug'] ?? '';

$project = null;
$index   = null;
foreach ($c['projects'] as $i => $p) {
    if (($p['slug'] ?? '') === $slug) {
        $project = $p;
        $index   = $i;
        break;
    }
}

if ($project === null):
    $viewStatus = 404;
    require __DIR__ . '/404.php';
else:
    $pageTitle = $project['name'] . ' — ' . $c['name'];
    $body      = $project['body'] ?? [];
    $highlights = $project['highlights'] ?? [];
    $links     = $project['links'] ?? [];
    $prev      = $c['projects'][($index + count($c['projects']) - 1) % count($c['projects'])] ?? null;
    $next      = $c['projects'][($index + 1) % count($c['projects'])] ?? null;
?>
<section class="section page-intro">
    <div class="container">
        <p class="eyebrow"><a class="crumb" href="/work">← <?= e($c['commands']['work']) ?></a></p>
        <div class="section-head">
            <h1 class="page-title"><?= e($project['name']) ?></h1>
            <span class="section-index mono"><?= sprintf('%02d', $index + 1) ?> / <?= sprintf('%02d', count($c['projects'])) ?></span>
        </div>
        <p class="lead" style="max-width: 62ch;"><?= e($project['summary']) ?></p>
        <div class="project-meta" style="margin-top: 18px;">
            <?php foreach ($project['tags'] as $i => $tag): ?>
                <?= $i > 0 ? ' · ' : '' ?><span class="tag"><?= e($tag) ?></span>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section--tight" data-reveal>
    <div class="container">
        <?php
        $slot = $project['image'] ?? '';
        if ($slot !== ''):
            $slotAlt = $project['name'] . ' — preview';
            $slotClass = 'img-slot img-slot--detail';
            require __DIR__ . '/partials/image-slot.php';
            unset($slot, $slotAlt, $slotClass);
        endif;
        ?>
    </div>
</section>

<section class="section" data-reveal>
    <div class="container">
        <div class="project-detail">
            <div class="project-detail-main">
                <h2 class="project-detail-h">About this project</h2>
                <?php foreach ($body as $paragraph): ?>
                    <p><?= e($paragraph) ?></p>
                <?php endforeach; ?>
            </div>
            <?php if (!empty($highlights) || !empty($links)): ?>
                <aside class="project-detail-side">
                    <?php if (!empty($highlights)): ?>
                        <h2 class="project-detail-h">Highlights</h2>
                        <ul class="project-highlights">
                            <?php foreach ($highlights as $item): ?>
                                <li><?= e($item) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <?php if (!empty($links)): ?>
                        <h2 class="project-detail-h">Links</h2>
                        <ul class="project-links">
                            <?php foreach ($links as $label => $href): ?>
                                <li><a href="<?= e($href) ?>" target="_blank" rel="noopener"><?= e($label) ?> ↗</a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </aside>
            <?php endif; ?>
        </div>

        <nav class="project-nav" aria-label="More projects">
            <?php if ($prev): ?>
                <a class="project-nav-link" href="/work/<?= e($prev['slug']) ?>">
                    <span class="mono">← previous</span>
                    <span><?= e($prev['name']) ?></span>
                </a>
            <?php endif; ?>
            <a class="project-nav-link" href="/work">
                <span class="mono">all projects</span>
                <span>See everything I've built</span>
            </a>
            <?php if ($next): ?>
                <a class="project-nav-link project-nav-link--next" href="/work/<?= e($next['slug']) ?>">
                    <span class="mono">next →</span>
                    <span><?= e($next['name']) ?></span>
                </a>
            <?php endif; ?>
        </nav>
    </div>
</section>
<?php endif; ?>
