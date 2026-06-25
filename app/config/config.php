<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'pmnm_68pm34_kieutuananh_0000568');

// Dynamic Base URL detection
if (!defined('BASE_URL')) {
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    // Typically /PMNM_68PM34_KieuTuanAnh_0000568/public/index.php
    $baseUrl = str_replace('/public/index.php', '/public', $scriptName);
    define('BASE_URL', $baseUrl);
}
?>
