<?php
/** Selected projects. */
$c = $data;
?>
<section class="section" data-reveal>
    <div class="container">
        <div class="section-head">
            <h2><?= e($c['commands']['projects']) ?></h2>
            <span class="section-index mono"><?= count($c['projects']) ?> shipped</span>
        </div>

        <div class="projects">
            <?php foreach ($c['projects'] as $project): ?>
                <article class="project">
                    <div>
                        <h3><a href="/work/<?= e($project['slug'] ?? '') ?>"><?= e($project['name']) ?></a></h3>
                        <p><?= e($project['summary']) ?></p>
                    </div>
                    <div class="project-meta">
                        <?php foreach ($project['tags'] as $i => $tag): ?>
                            <?= $i > 0 ? ' · ' : '' ?><span class="tag"><?= e($tag) ?></span>
                        <?php endforeach; ?>
                        <a class="project-link mono" href="/work/<?= e($project['slug'] ?? '') ?>">details →</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>