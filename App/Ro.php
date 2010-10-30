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
class App_Ro extends BEAR_Ro
{
    /**
     * ユーザー
     *
     * @var string
     */
    const TABLE_USER = 'users';


    /**
     * DAO
     *
     * @var BEAR_MDB2
     */
    protected $_db;

    /**
     * コンストラクタ
     *
     * @param array $config 設定
     */
    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    /**
     * インジェクタ
     *
     * <pre>
     * 操作によってDBオブジェクトを変更します
     *
     * read操作はdsnをslaveに、DBページャーを利用可能に。
     * その他操作はdsnをdefaultに、トランザクション可能にしExtendedモジュール読み込みます
     * </pre>
     */
    public function onInject()
    {
        $app = BEAR::get('app');
        assert(is_string($app['App_Db']['dsn']['default']));
        assert(is_string($app['App_Db']['dsn']['slave']));
        assert(isset($this->_config['method']));
        $options['default_table_type'] = 'INNODB';
        if ($this->_config['method'] === 'read') {
            $dsn = $app['App_Db']['dsn']['slave'];
            $config = array('dsn' => $dsn, 'options' => $options);
            $this->_db = BEAR::factory('BEAR_Mdb2', $config);
            $this->_queryConfig =  array('db'=>&$this->_db, 'ro'=>&$this, 'table'=>$this->_table, 'pager'=>0, 'perPage'=>10, 'options'=>array('accesskey'=>true));
        } else {
            $dsn = $app['App_Db']['dsn']['default'];
            $options['use_transactions'] = true;
            $config = array('dsn' => $dsn, 'options' => $options);
            $this->_db = BEAR::factory('BEAR_Mdb2', $config);
            $this->_db->loadModule('Extended');
            $this->_queryConfig =  array('db'=>&$this->_db, 'ro'=>&$this, 'table'=>$this->_table);
        }
        // すべてのフィールド識別子が SQL 文中で自動的にクォート
        $this->_db->setOption('quote_identifier', true);
    }

    /**
     * インジェクタ
     *
     * SELECTクエリーをCOUNTに変更します
     *
     */
    public function onInjectCount()
    {
        $this->onInject();
        $this->_query = BEAR::dependency('BEAR_Query_Count', $this->_queryConfig);
    }

    /**
     * DAO取得
     *
     * <pre>
     * AOP用。トランザクションアドバイスがDBオブジェクトを取得するのに使用しています。
     * </pre>
     */
    public function getDb()
    {
        return $this->_db;
    }
}
