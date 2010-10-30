<?php
/**
 * BEAR
 *
 * PHP versions 5
 *
 * @category   BEAR
 * @package    App
 * @subpackage Execute
 * @author     Akihito Koriyama <koriyama@bear-project.net>
 * @copyright  2008 Akihito Koriyama  All rights reserved.
 * @license    http://opensource.org/licenses/bsd-license.php BSD
 * @version    SVN: Release: $Id: App.php 242 2009-08-19 10:32:20Z koriyama $
 * @link       http://api.bear-project.net/BEAR_Resource/BEAR_Resource.html
 */
/**
 * スタティクファイルリソースクラス
 *
 * <pre>
 * スタティクファイルをリソースとして扱うクラスです。XML, YAML, CSV, INIファイルをサポートしています。
 * </pre>
 *
 * @category   BEAR
 * @package    App
 * @subpackage Execute
 * @author     Akihito Koriyama <koriyama@bear-project.net>
 * @copyright  2008 Akihito Koriyama  All rights reserved.
 * @license    http://opensource.org/licenses/bsd-license.php BSD
 * @version    SVN: Release: $Id: App.php 242 2009-08-19 10:32:20Z koriyama $
 * @link       http://api.bear-project.net/BEAR_Resource/BEAR_Resource.html
 *  */
class App_Resource_Execute_App extends BEAR_Resource_Execute_Adaptor
{

    /**
     * コンストラクタ
     *
     * <pre>
     * $config['method']  string アクセスメソッド
     * $config['uri']     string URI
     * $config['values']  string 引数
     * $config['options'] string オプション
     * </pre>
     *
     * @param array $config 設定
     */
    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    /**
     * リソースアクセス
     *
     * <pre>
     * リソースを使用します。
     *
     *
     * @param void
     *
     * @return mixed
     */
    public function request()
    {
        // read only
        if ($this->_config['method'] === BEAR_Resource::METHOD_READ) {
            $file = str_replace('app:/', '', $this->_config['uri']);
            $result = file_get_contents($file);
        } else {
            $config = array('info' => compact('method'), 'code' => 400);
            throw new BEAR_Resource_Exception('Method not allowed', $config);
        }
        return $result;
    }
}