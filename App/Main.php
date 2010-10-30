<?php
/**
 * @APP@
 *
 * @category   BEAR
 * @package    App
 * @subpackage Class
 * @author     $Author: anonymous$ <username@example.com>
 * @license    unknown http://www.example.com/
 * @version    SVN: Release: $Id:$
 * @link       http://www.example.com/
 */

/**
 * アプリケーションメイン
 *
 * @category   BEAR
 * @package    App
 * @subpackage Class
 * @author     $Author: anonymous $ <anonymous@example.com>
 * @copyright  anonymous All rights reserved.
 * @version    SVN: Release: $Id:$
 */
class App_Main extends BEAR_Main
{
    /**
     * コンストラクタ
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
        // エージェントスニッフィング
        BEAR_Main_Ua_Injector::inject($this, $this->_config);
        parent::onInject();
    }
}