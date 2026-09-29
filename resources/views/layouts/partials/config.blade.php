<?php
if (!isset($pageTitle))    $pageTitle    = config('site.name') . ' | ' . config('site.tagline');
if (!isset($headerClass))  $headerClass  = 'header-v1';
if (!isset($currentPage))  $currentPage  = '';
if (!isset($extraCss))     $extraCss     = [];
if (!isset($extraScripts)) $extraScripts = [];

if (!function_exists('nav_active')) {
    function nav_active(string $page, string $current): string {
        return ($page === $current) ? ' active' : '';
    }
}
