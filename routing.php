<?php
// ===============================
// Routing central del proyecto
// ===============================

// Ruta física en el servidor (para require/include)
if (!defined('BASE_PATH')) {
    define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);
}

// Ruta pública (para enlaces en HTML)
if (!defined('BASE_URL')) {
    define('BASE_URL', ''); // porque todo está en htdocs raíz
}

// Carpetas públicas
if (!defined('PUBLIC_PATH')) define('PUBLIC_PATH', BASE_PATH . '/public/');
if (!defined('PUBLIC_URL')) define('PUBLIC_URL', BASE_URL . '/public/');

// Páginas
if (!defined('PUBLIC_PAGES')) define('PUBLIC_PAGES', PUBLIC_PATH . 'pages/');
if (!defined('PUBLIC_PAGES_URL')) define('PUBLIC_PAGES_URL', PUBLIC_URL . 'pages/');
if (!defined('PUBLIC_PAGES_COMPONENTS')) define('PUBLIC_PAGES_COMPONENTS', PUBLIC_PAGES . 'components/');
if (!defined('PUBLIC_PAGES_COMPONENTS_URL')) define('PUBLIC_PAGES_COMPONENTS_URL', PUBLIC_PAGES_URL . 'components/');

// PHP
if (!defined('PUBLIC_PHP')) define('PUBLIC_PHP', PUBLIC_PATH . 'php/');
if (!defined('PUBLIC_PHP_URL')) define('PUBLIC_PHP_URL', PUBLIC_URL . 'php/');
if (!defined('PUBLIC_PHP_FUNCTIONS')) define('PUBLIC_PHP_FUNCTIONS', PUBLIC_PHP . 'func/');
if (!defined('PUBLIC_PHP_FUNCTIONS_URL')) define('PUBLIC_PHP_FUNCTIONS_URL', PUBLIC_PHP_URL . 'func/');

// Recursos
if (!defined('PUBLIC_RESOURCES')) define('PUBLIC_RESOURCES', PUBLIC_PATH . 'res/');
if (!defined('PUBLIC_RESOURCES_URL')) define('PUBLIC_RESOURCES_URL', PUBLIC_URL . 'res/');
if (!defined('PUBLIC_RESOURCES_IMAGES')) define('PUBLIC_RESOURCES_IMAGES', PUBLIC_RESOURCES . 'img/');
if (!defined('PUBLIC_RESOURCES_IMAGES_URL')) define('PUBLIC_RESOURCES_IMAGES_URL', PUBLIC_RESOURCES_URL . 'img/');
if (!defined('PUBLIC_RESOURCES_GIF')) define('PUBLIC_RESOURCES_GIF', PUBLIC_RESOURCES . 'gif/');
if (!defined('PUBLIC_RESOURCES_GIF_URL')) define('PUBLIC_RESOURCES_GIF_URL', PUBLIC_RESOURCES_URL . 'gif/');
if (!defined('PUBLIC_RESOURCES_CARDS')) define('PUBLIC_RESOURCES_CARDS', PUBLIC_RESOURCES . 'cards/');
if (!defined('PUBLIC_RESOURCES_CARDS_URL')) define('PUBLIC_RESOURCES_CARDS_URL', PUBLIC_RESOURCES_URL . 'cards/');
if (!defined('PUBLIC_RESOURCES_ANIMAL_PROFILES')) define('PUBLIC_RESOURCES_ANIMAL_PROFILES', PUBLIC_RESOURCES . 'animal_profiles/');
if (!defined('PUBLIC_RESOURCES_ANIMAL_PROFILES_URL')) define('PUBLIC_RESOURCES_ANIMAL_PROFILES_URL', PUBLIC_RESOURCES_URL . 'animal_profiles/');

// Scripts y estilos
if (!defined('PUBLIC_SCRIPTS')) define('PUBLIC_SCRIPTS', PUBLIC_PATH . 'scripts/');
if (!defined('PUBLIC_SCRIPTS_URL')) define('PUBLIC_SCRIPTS_URL', PUBLIC_URL . 'scripts/');
if (!defined('PUBLIC_STYLES')) define('PUBLIC_STYLES', PUBLIC_PATH . 'styles/');
if (!defined('PUBLIC_STYLES_URL')) define('PUBLIC_STYLES_URL', PUBLIC_URL . 'styles/');

// Globales
if (!defined('ACTUALIZACION_ULTIMA')) define('ACTUALIZACION_ULTIMA', '2025-11-15');
