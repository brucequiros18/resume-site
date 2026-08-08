<?php
/**
 * Route model — declares every route the app knows about.
 * Adding a page = adding one entry here + one view file.
 * Systematic: a single registry means no hidden routes, no string typos in matchers.
 */

$name = require __DIR__ . '/config/content.php';

return [
    'GET' => [
        '/'           => ['view' => 'home',    'title' => $name['title']],
        '/about'      => ['view' => 'about',   'title' => 'About — ' . $name['name']],
        '/work'       => ['view' => 'work',    'title' => 'Work — ' . $name['name']],
        '/uses'       => ['view' => 'uses',    'title' => 'Uses — ' . $name['name']],
        '/work/{slug}' => ['view' => 'project', 'title' => 'Project — ' . $name['name']],
        '/contact'    => ['view' => 'contact', 'title' => 'Contact — ' . $name['name']],
        '/resume.pdf' => ['handler' => 'resume', 'title' => $name['name'] . ' — Resume'],
    ],
    'POST' => [
        '/contact' => ['handler' => 'contact.handle', 'title' => 'Contact — ' . $name['name']],
    ],
];
