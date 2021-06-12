<?php

define('APP_NAME', 'framework');
define('APP_URL', 'http://framework.loc');

define('DEBUG_MODE', true);

define('COOKIE_LIFETIME', 86400);
define('SESSION_LIFETIME', 86400);

define('CONTROLLERS_NAMESPACE', 'App\\Controllers\\');
define('MODELS_NAMESPACE', 'App\\Models\\');

define('BASE_DIR', dirname(__DIR__));
define('CORE_DIR', BASE_DIR . '/core');
define('CONFIG_DIR', BASE_DIR . '/config');
define('APP_DIR', BASE_DIR . '/app');
define('PUBLIC_DIR', BASE_DIR . '/public');
define('STORAGE_DIR', BASE_DIR . '/storage');
define('APP_CACHE_DIR', STORAGE_DIR . '/app/cache');
