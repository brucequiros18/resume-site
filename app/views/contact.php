<?php
/** Contact — info list + validated form (server-side). */
$c = $data;
$sent      = flash_sent();
$formError = field_error('_form');
$csrfError = field_error('_csrf');
?>
<section class="section">
    <div class="container">
        <p class="eyebrow"><?= e($c['commands']['contact']) ?></p>
        <div class="section-head">
            <h2>Let's build your<br>next project together.</h2>
        </div>

        <div class="contact-grid">
            <div>
                <?php
                $slot = $c['images']['avatar'];
                $slotAlt = 'Nash Bruce Quiros';
                $slotClass = 'img-slot img-slot--portrait img-slot--contact';
                require __DIR__ . '/partials/image-slot.php';
                unset($slot, $slotAlt, $slotClass);
                ?>

                <ul class="contact-list">
                    <li>
                        <span class="c-label">Email</span>
                        <a class="c-value" href="mailto:<?= e($c['email']) ?>"><?= e($c['email']) ?></a>
                    </li>
                    <li>
                        <span class="c-label">Phone</span>
                        <a class="c-value" href="tel:<?= e(preg_replace('/[^0-9+]/', '', $c['phone'])) ?>"><?= e($c['phone']) ?></a>
                    </li>
                    <li>
                        <span class="c-label">Base</span>
                        <span class="c-value"><?= e($c['location']) ?></span>
                    </li>
                    <li>
                        <span class="c-label">Availability</span>
                        <span class="c-value"><?= $c['available'] ? e($c['availability']) : 'Currently booked' ?></span>
                    </li>
                </ul>

                <p class="c-label" style="margin: 30px 0 14px;">Find me on</p>
                <div class="socials">
                    <?php require __DIR__ . '/partials/socials.php'; ?>
                </div>
            </div>

            <div>
                <?php if ($sent): ?>
                    <div class="form-alert" role="status">
                        Message sent — thanks. I'll get back to you within 48 hours.
                    </div>
                <?php elseif ($formError || $csrfError): ?>
                    <div class="form-alert form-alert--danger" role="alert">
                        <?= e(trim($formError . ' ' . $csrfError)) ?>
                    </div>
                <?php endif; ?>

                <form class="form-card" method="post" action="/contact" data-ajax-lock novalidate>
                    <?= csrf_field() ?>

                    <div class="visually-hidden" aria-hidden="true">
                        <label for="website">Leave this field empty</label>
                        <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="form-group<?= field_error('name') ? ' invalid' : '' ?>">
                        <label for="name">Name</label>
                        <input id="name" name="name" type="text" maxlength="70" autocomplete="name"
                               placeholder="Your name" value="<?= old_value('name') ?>" required>
                        <?php if (field_error('name')): ?>
                            <span class="field-error" role="alert"><?= field_error('name') ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group<?= field_error('email') ? ' invalid' : '' ?>">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" maxlength="190" autocomplete="email"
                               placeholder="you@example.com" value="<?= old_value('email') ?>" required>
                        <?php if (field_error('email')): ?>
                            <span class="field-error" role="alert"><?= field_error('email') ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group<?= field_error('message') ? ' invalid' : '' ?>">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" maxlength="4000"
                                  placeholder="Tell me about your project idea, mobile app, website, game, or AI solution." required><?= old_value('message') ?></textarea>
                        <p class="form-note">12–4000 characters</p>
                        <?php if (field_error('message')): ?>
                            <span class="field-error" role="alert"><?= field_error('message') ?></span>
                        <?php endif; ?>
                    </div>

                    <button class="btn btn--primary" type="submit">Send message</button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php clear_contact_flash(); ?>