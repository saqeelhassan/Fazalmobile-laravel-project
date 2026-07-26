<?php
if (!defined('SITE_NAME'))    define('SITE_NAME',    config('site.name'));
if (!defined('SITE_TAGLINE')) define('SITE_TAGLINE', config('site.tagline'));
if (!defined('SITE_EMAIL'))   define('SITE_EMAIL',   config('site.email'));
if (!defined('SITE_PHONE'))   define('SITE_PHONE',   config('site.phone'));
if (!defined('SITE_ADDRESS')) define('SITE_ADDRESS', config('site.address'));

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
