<?php

return [
    'auth' => \App\Middleware\RedirectIfNotAuthenticated::class,
    'guest' => \App\Middleware\RedirectIfAuthenticated::class,
];