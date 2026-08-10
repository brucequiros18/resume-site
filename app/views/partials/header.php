<?php
/** Terminal-chrome sticky header + navigation. $req and $data are in scope from the layout. */
?>
<header class="site-header">
    <nav class="nav container" aria-label="Main">
        <a class="brand" href="/" aria-label="<?= e($data['name']) ?> — home">
            <span class="chrome-lights" aria-hidden="true">
                <span class="chrome-light chrome-light--r"></span>
                <span class="chrome-light chrome-light--a"></span>
                <span class="chrome-light chrome-light--g"></span>
            </span>
            <span class="chrome-title">nash@portfolio</span>
        </a>

        <input type="checkbox" id="nav-toggle" class="nav-toggle-input">
        <label for="nav-toggle" class="nav-toggle" aria-label="Open menu">☰</label>

        <ul class="nav-links" id="site-links">
            <li><a href="/work"<?= ($req->path === '/work' || str_starts_with($req->path, '/work/')) ? ' aria-current="page"' : '' ?>>Work</a></li>
            <li><a href="/uses"<?= active_path($req, '/uses') ?>>Uses</a></li>
            <li><a href="/about"<?= active_path($req, '/about') ?>>About</a></li>
            <li><a href="/contact"<?= active_path($req, '/contact') ?>>Contact</a></li>
        </ul>

        <input type="checkbox" id="theme-toggle" class="theme-toggle-input">
        <label for="theme-toggle" class="theme-toggle" aria-label="Switch accent theme" title="Switch accent theme">
            <span class="theme-toggle-dot" aria-hidden="true"></span>
        </label>
    </nav>
</header>