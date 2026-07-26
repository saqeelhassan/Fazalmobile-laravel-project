<?php
if (!defined('SITE_NAME'))    define('SITE_NAME',    'E-Come Electronics Store');
if (!defined('SITE_TAGLINE')) define('SITE_TAGLINE', 'Multi-Purpose HTML Template for Electronics Store');
if (!defined('SITE_EMAIL'))   define('SITE_EMAIL',   'contact@yourcompany.com');
if (!defined('SITE_PHONE'))   define('SITE_PHONE',   '(+123) 456 789');

if (!isset($pageTitle))    $pageTitle    = SITE_NAME . ' | ' . SITE_TAGLINE;
if (!isset($headerClass))  $headerClass  = 'header-v1';
if (!isset($currentPage))  $currentPage  = '';
if (!isset($extraCss))     $extraCss     = [];
if (!isset($extraScripts)) $extraScripts = [];

if (!function_exists('nav_active')) {
    function nav_active(string $page, string $current): string {
        return ($page === $current) ? ' active' : '';
    }
}
