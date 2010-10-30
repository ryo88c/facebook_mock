<?php
/**
 * App
 *
 * @category   BEAR
 * @package    App
 * @subpackage Class
 * @author     $Author: $ <username@example.com>
 * @license    unknown http://www.example.com/
 * @version    SVN: Release: $Id$
 * @link       http://www.example.com/
 */
/**
 * プロジェクトルートパス
 */
define('_BEAR_APP_HOME', realpath(dirname(__FILE__)));

$bearMode = (isset($_SERVER['bearmode']) && !isset($_GET['_live'])) ? $_SERVER['bearmode'] : 0;
// プロファイルオプション （要xdebug+xhprof)
//include _BEAR_APP_HOME . '/App/prof.php';

/**
 * BEAR
 */
require_once 'BEAR.php';

/**
 * App実行
 */
App::init($_SERVER['bearmode']);

/**
 * アプリケーションクラス
 *
 * @category   BEAR
 * @package    App
 * @author     $Author: koriyama@bear-project.net $ <anonymous@example.com>
 * @copyright  anonymous All rights reserved.
 * @license
 * @version    SVN: Release: $Id: App.php 1330 2010-01-20 22:55:10Z koriyama@bear-project.net $
 *
 */
class App
{
    /**
     * アプリケーション実行
     *
     * @param int $mode 動作モード
     *
     * @return void
     */
    public static function init($mode = 1)
    {
        $app = BEAR::loadConfig(_BEAR_APP_HOME . '/App/app.yml');
        switch ($mode) {
            case 2 :
            case 1 :
                //開発モード （キャッシュ有効)
                $app['core']['debug'] = true;
                $app['App_Db']['dsn']['default'] = $app['App_Db']['dsn']['slave'] = $app['App_Db']['dsn']['test'];
                $app['BEAR_Ro_Prototype']['__class'] = 'BEAR_Ro_Prototype_Debug';
                break;
            case 0 :
            default :
                //ライブ
                $app['core']['debug'] = false;
                break;
        }
        BEAR::init($app);
        // 開発モード(キャッシュクリア）
        if ($mode == 1) {
            BEAR_Util::clearAllCache(false);
        }
    }

    /**
     * コールバック
     *
     * @param string $event 　イベント
     * @param array  $config
     */
    public static function onCall($event, array $config)
    {
    }
}
