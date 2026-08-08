<?php
/** Experience timeline. $data in scope from the caller. */
$c = $data;
?>
<section class="section" data-reveal>
    <div class="container">
        <div class="section-head">
            <h2><?= e($c['commands']['experience']) ?></h2>
            <span class="section-index mono"><?= count($c['experience']) ?> role</span>
        </div>

        <div class="timeline">
            <?php foreach ($c['experience'] as $job): ?>
                <article class="job">
                    <p class="job-period mono"><?= e($job['period']) ?><br><?= e($job['location']) ?></p>
                    <div>
                        <div class="job-head">
                            <h3><?= e($job['role']) ?></h3>
                        </div>
                        <p class="job-org" style="margin: 0 0 10px;"><?= e($job['org']) ?></p>
                        <p class="job-summary"><?= e($job['summary']) ?></p>

                        <?php if (!empty($job['specializations'])): ?>
                            <h4 class="job-subhead">Specializations</h4>
                            <ul class="chips" aria-label="Specializations">
                                <?php foreach ($job['specializations'] as $spec): ?>
                                    <li class="chip"><?= e($spec) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <?php if (!empty($job['skills'])): ?>
                            <h4 class="job-subhead" style="margin-top: 26px;">Core skills</h4>
                            <ul class="chips" aria-label="Core skills">
                                <?php foreach ($job['skills'] as $skill): ?>
                                    <li class="chip chip--accent"><?= e($skill) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>