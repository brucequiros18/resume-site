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

        <button class="nav-toggle" aria-expanded="false" aria-controls="site-links" aria-label="Open menu">☰</button>

        <ul class="nav-links" id="site-links">
            <li><a href="/work"<?= ($req->path === '/work' || str_starts_with($req->path, '/work/')) ? ' aria-current="page"' : '' ?>>Work</a></li>
            <li><a href="/uses"<?= active_path($req, '/uses') ?>>Uses</a></li>
            <li><a href="/about"<?= active_path($req, '/about') ?>>About</a></li>
            <li><a href="/contact"<?= active_path($req, '/contact') ?>>Contact</a></li>
            <li><a class="nav-cta" href="/resume.pdf">Resume</a></li>
        </ul>

        <button class="theme-toggle" type="button" aria-pressed="false"
                aria-label="Switch accent theme" title="Switch accent theme">
            <span class="theme-toggle-dot" aria-hidden="true"></span>
        </button>
    </nav>
</header>