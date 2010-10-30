<?php
/**
 * プロファイラースタート（デバック用）
 *
 * ?_profクエリーをつけるとデバックモードoffで実行され、実行開始時にプロファイリングがスタートします。
 * xdebug, xhprof, (graphviz)が必要です。
 */
if ($bearMode !== 0 && isset($_GET['_prof']) && function_exists('xhprof_enable')) {
    include 'BEAR/Prof.php';
    BEAR_Prof::start();
    // ライブモードに
    $bearMode = 0;
}