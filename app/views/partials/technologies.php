<?php
/** Technologies — programming languages + frameworks & tools. */
$c = $data;
$embedded = !empty($embedded);
if (!$embedded): ?>
<section class="section" data-reveal>
    <div class="container">
<?php endif; ?>
        <div class="section-head">
            <h2><?= e($c['commands']['stack']) ?></h2>
            <span class="section-index mono">stack</span>
        </div>

        <div class="tech-grid">
            <div>
                <h3 class="tech-head">Programming Languages</h3>
                <ul class="chips">
                    <?php foreach ($c['languages'] as $lang): ?>
                        <li class="chip"><?= e($lang) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div>
                <h3 class="tech-head">Frameworks &amp; Tools</h3>
                <ul class="chips">
                    <?php foreach ($c['frameworks'] as $fw): ?>
                        <li class="chip"><?= e($fw) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
<?php if (!$embedded): ?>
    </div>
</section>
<?php endif; ?>