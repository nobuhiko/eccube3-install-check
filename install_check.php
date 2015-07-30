<?php
/*
 * EC-CUBE 3 要件チェックスクリプト
 * Copyright (C) 2015 Nobuhiko Kimoto
 * info@nob-log.info
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 */

$error = 0;
$warning = 0;

echo 'EC-CUBE 3 <a href="http://www.ec-cube.net/product/system.php">ソフトウェア要件</a><br>';

// PHPのバージョンチェック
if (version_compare(phpversion(), '5.3.9', '<')) {
    echo ("PHPのバージョンはPHP5.3.9以降を必要とします。<br>");
}

$required_modules = array('pdo', 'phar', 'mbstring', 'zlib',
'ctype', 'session', 'JSON', 'xml', 'libxml', 'OpenSSL', 'zip', 'cURL', 'fileinfo');
$recommended_module = array('hash', 'APC', 'mcrypt');
foreach ($required_modules as $module) {
    if (!extension_loaded($module)) {
        echo ("[必須PHPライブラリ] " . $module . " 拡張モジュールが有効になっていません。<br>");
        $error++;
    }
}

/*
if (extension_loaded('gd')) {
    $gdInfo = gd_info();
    if (empty($gdInfo['FreeType Support'])) {
        echo ("[必須PHPライブラリ] FreeType 拡張モジュールが有効になっていません。<br>");
        $error++;
    }
}*/

if (!extension_loaded('pdo_mysql') && !extension_loaded('pdo_pgsql')) {
    echo ('[必須PHPライブラリ] pdo_pgsql又はpdo_mysql 拡張モジュールを有効にしてください。<br>');
    $error++;
}

foreach ($recommended_module as $module) {
    if (!extension_loaded($module)) {
        echo ('[推奨PHPライブラリ] ' . $module . ' 拡張モジュールが有効になっていません。<br>');
        $warning++;
    }
}

if ( function_exists('apache_get_modules') && in_array('mod_rewrite',apache_get_modules()) ) {
    $mod_rewrite = TRUE;
} elseif ( isset($_SERVER['IIS_UrlRewriteModule']) ) {
    $mod_rewrite = TRUE;
} elseif ( !function_exists('apache_get_modules')) {
    echo ('mod_rewriteが有効になっているか不明です。 <br>');
    $warning++;

} else {
    echo ('mod_rewriteが有効になっていません。<br>');
    $error++;
}

/* localhost のmysqlのバージョンを調べても仕方がない
if (function_exists('mysql_get_client_info') && version_compare(mysql_get_client_info(), '5.1', '<')) {
    echo ("MySQLのバージョンは5.1以降を必要とします。<br>");
    $error++;
}*/

// todo postgresのバージョンは無理？
//
//
if ($error == 0) {
    echo ("<strong>EC-CUBE3の動作要件を満たしているようです。</strong><br>");
}

echo 'created by <a href="http://nob-log.info/">nob-log.info<a>';
