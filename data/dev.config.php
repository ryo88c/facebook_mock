<?php
/**
 * 開発環境設定
 *
 * このパスを環境に合わせて変更してください。
 * MySQLのログを出力するためにはMySQLの設定が必要です。
 *
 */
// Apache アクセスログ
$file['apache_access'] = '/opt/local/apache2/logs/access_log';
// Apache エラーログ
$file['apache_error'] = '/opt/local/apache2/logs/error_log';
// MySQL クエリーログ
$file['mysql_query'] = '/opt/local/var/db/mysql5/query.log';
// MySQL スロークエリーログ
$file['mysql_slow'] = '/opt/local/var/db/mysql5/query-slow.log';
// MySQL index不使用クエリーログ
$file['mysql_no_index'] = '/opt/local/var/db/mysql5/query-no-index.log';
// pearのインストールディレクトリ　(PEARとPEAR.phpが含まれています)
$pear_dir = '/usr/share/php'; // default of install
// pear設定ファイル 通常の場所にあれば指定はいりません
//$pear_user_config = '/Users/username/.pearrc';
/**
 * 設定が完了したら下の値を1にしてください
 */
$isSet = 0;