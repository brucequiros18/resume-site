<?php
/**
 * Optional image slot.
 * Require after setting: $slot (relative path, e.g. "images/avatar.jpg"),
 * $slotAlt (short description), optional $slotClass.
 *
 * If the file exists under public/, renders the <img>.
 * Otherwise renders an elegant placeholder showing the expected filename —
 * drop the image in public/<path> and it appears automatically.
 */
$slotFile = __DIR__ . '/../../../public/' . $slot;
$slotClass = isset($slotClass) ? $slotClass : 'img-slot';
$slotAlt = isset($slotAlt) ? $slotAlt : 'Image';
$shows = is_file($slotFile);
?>
<figure class="<?= e($slotClass) ?><?= $shows ? '' : ' img-slot--empty' ?>">
    <?php if ($shows): ?>
        <img src="/<?= e($slot) ?>" alt="<?= e($slotAlt) ?>" loading="lazy">
    <?php else: ?>
        <span class="img-hint" role="img" aria-label="Image slot for <?= e($slotAlt) ?>">
            <svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true" focusable="false">
                <path fill="currentColor" d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zm-1.5 8.5-3.9 5.4-2.6-3.1-3.5 4.2H5V5h14v6.5zM8.5 7.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3z"/>
            </svg>
            <span class="img-hint-path"><?= e($slot) ?></span>
        </span>
    <?php endif; ?>
</figure>
