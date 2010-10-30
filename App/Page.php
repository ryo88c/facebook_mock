<?php
/**
 * @APP@
 *
 * @category   BEAR
 * @package    App
 * @subpackage Page
 * @author     $Author: anonymous$ <username@example.com>
 * @license    unknown http://www.example.com/
 * @version    SVN: Release: $Id:$
 * @link       http://www.example.com/
 */
/**
 * アプリケーションページ
 *
 * @category   BEAR
 * @package    App
 * @subpackage Page
 * @author     $Author: koriyama@bear-project.net $ <username@example.com>
 * @license    unknown http://www.example.com/
 * @version    SVN: Release: $Id: Page.php 1260 2009-12-08 14:41:23Z koriyama@bear-project.net $
 * @link       http://www.example.com/
 * @abstract
 */
abstract class App_Page extends BEAR_Page
{

    /**
     *  セッション
     *
     * @var BEAR_Session
     */
    protected $_session;

    /**
     * リソースアクセス
     *
     * @var BEAR_Resource
     */
    protected $_resource;

    /**
     * コンストラクタ
     *
     * @param array $config 設定
     */
    function __construct(array $config)
    {
        parent::__construct($config);
    }

    /**
     * インジェクト
     *
     * @return void
     */
    public function onInject()
    {
        parent::onInject();
        $this->_session = BEAR::dependency('BEAR_Session');
        $this->_resource = BEAR::dependency('BEAR_Resource');
    }

    /**
     * 出力
     *
     * @return void
     */
    public function onOutput()
    {
        $this->display();
    }

    /**
     * 例外
     *
     * @return void
     */
    public function onException(Exception $e){
        //p($e->getMessage());
        throw $e;
    }

    /**
     * セッションタイムアウト
     *
     */
    public function onSessionTimeout()
    {
    }
}
