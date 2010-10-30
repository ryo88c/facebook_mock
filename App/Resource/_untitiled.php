<?php
/**
 * App_Ro
 *
 * @package    App_Ro
 * @subpackage Resource
 */

/**
 * Untitledリソース
 *
 * <pre>
 * description here...
 * </pre>
 *
 * @category   BEAR
 * @package    App_Ro
 * @subpackage Resource
 * @author     $Author: koriyama@bear-project.net $ <username@example.com>
 * @version    SVN: Release: $Id: _untitiled.php 835 2009-08-18 03:54:51Z koriyama@bear-project.net $
 */
class App_Ro_Untitled extends BEAR_Ro
{
    /**
     * テーブル名
     *
     * @var string
     */
    private $_table = 'table';

    /**
     * コンストラクタ
     */
    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    /**
     * リソース作成
     *
     * <pre>
     * 'name' string 名前
     * </pre>
     *
     * @param array $values 引数
     *
     * @return MDB2_Resultそ
     */
    public function onCreate($values)
    {
        $extended = &$this->_db->extended;
        /** @param $extended MDB2_Extended */
        $values['created_at'] = _BEAR_DATETIME; //現在時刻
        $result = $extended->autoExecute($this->_table, $values, MDB2_AUTOQUERY_INSERT);
        if (MDB2::isError($result, MDB2_ERROR_CONSTRAINT)) {
            throw new Panda_Exception('IDが重複しています', 409);
        } elseif (MDB2::isError($result)) {
            throw new Panda_Exception('登録できませんでした', 500);
        }
        return $result;
    }

    /**
     * リソース変更
     *
     * <pre>
     * 'id' int ID
     * </pre>
     *
     * @param array $values 引数
     * @return MDB2_Result
     * @required id
     */
    public function onUpdate($values)
    {
        assert(isset($values['user']));
        $extended = & $this->_db->extended;
        $values['updated_at'] = _BEAR_DATETIME;
        /* @var $extended MDB2_Extended */
        $where = 'id = ' . $this->_db->quote($values['id'], 'integer');
        $extended->autoExecute($this->_table, $values, MDB2_AUTOQUERY_UPDATE, $where);
        if (!isset($values['profile'])) {
            return;
        }
        // profile
        $params = $values['profile'];
        $where = 'user_id = ' . $this->_db->quote($values['id'], 'integer');
        $params['updated_at'] = _BEAR_DATETIME;
        $result = $extended->autoExecute(App_DB::TABLE_PROFILE, $params, MDB2_AUTOQUERY_UPDATE, $where);
        if (!$result) {
            // updateできなかったらinsert
            unset($params['updated_at']);
            $params['user_id'] = $this->_db->quote($values['id'], 'integer');
            $params['created_at'] = _BEAR_DATETIME;
            $result = $extended->autoExecute(App_DB::TABLE_PROFILE, $params, MDB2_AUTOQUERY_INSERT);
        }
        return $result;
    }

    /**
     * リソース読み込み
     *
     * <pre>
     * 'id' int ID なかったら全件
     * </pre>
     *
     * @param array $values 引数
     *
     * @return array
     */
    public function onRead($values)
    {
        //db
        $where = isset($values['id']) ? ' WHERE id = ' . $this->_db->quote($values['id'], 'integer') : "";
        $sql = "SELECT * FROM {$this->_table}{$where}";
        if (isset($values['id'])) {
            $result = $this->_db->queryRow($sql);
        } else {
            $result = $this->_db->queryAll($sql);
        }
        return $result;
    }

    /**
     * リソース削除
     *
     * <pre>
     * 'id' int ID
     * </pre>
     *
     * @param array $values 引数
     *
     * @return MDB2_Result
     *
     * @required id
     */
    public function onDelete($values)
    {
        $extended = & $this->_db->extended;
        $values['deleted_at'] = _BEAR_DATETIME;
        /* @var $extended MDB2_Extended */
        $where = 'id = ' . $this->_db->quote($values['id'], 'integer');
        $result = $extended->autoExecute($this->_table, $values, MDB2_AUTOQUERY_UPDATE, $where);
        return $result;
    }

    /**
     * リンク
     *
     * @required id
     */
    function onLink($values)
    {
        $links = array('profile' => "user/profile?user_id={$values['id']}");
        return $links;
    }
}