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
 * アプリケーションDBクラス
 *
 * @category   BEAR
 * @package    App
 * @subpackage Class
 * @author     $Author:$ <username@example.com>
 * @license    unknown http://www.example.com/
 * @version    SVN: Release: $Id:$
 * @link       http://www.example.com/
 */
class App_Db extends BEAR_Factory
{

    /**
     * DBインスタンス取得
     *
     * 親クラスのgetInstace()からDSNにDBドライバオブジェクトを取得
     *
     * @param string $dsn    DSN
     * @param array  $option オプション
     *
     * @return array (string, MDB2_Driver_Datatype_mysqli)
     *
     * @required dsn DSN
     */
    public function factory()
    {
        $options['default_table_type'] = 'INNODB';
        $options['use_transactions'] = true;
        $config = array('dsn' => $this->_config['dsn']);
        $config['options'] = $options;
        $db = BEAR::factory('BEAR_Mdb2', $config);
        /** @var $db BEAR_Mdb2 */
        // すべてのフィールド識別子が SQL 文中で自動的にクォート
        $db->setOption('quote_identifier', true);
        $db->loadModule('Extended');
        return $db;
    }
}
