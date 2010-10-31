<?php
/**
 * アプリケーションページ基底クラス
 *
 * @category   BEAR
 * @package    App
 * @subpackage Page
 * @author     HAYASHI Ryo <ryo@spais.co.jp>
 * @version    0.1.0
 * @abstract
 */
abstract class App_Page extends BEAR_Page
{

    /**
     * セッション
     * @var BEAR_Session
     */
    protected $_session;

    /**
     * リソースアクセス
     * @var BEAR_Resource
     */
    protected $_resource;

    /**
     * permission のチェック(無ければ許可ページにリダイレクト)
     * @param array $permissions
     */
    protected function checkPermission(array $permissions){

    }

    /**
     * コンストラクタ
     * @param array $config 設定
     */
    function __construct(array $config)
    {
        parent::__construct($config);
    }

    /**
     * インジェクト
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
     * @return void
     */
    public function onOutput()
    {
        $this->display();
    }

    /**
     * 例外
     * @return void
     */
    public function onException(Exception $e){
        //p($e->getMessage());
        throw $e;
    }
}