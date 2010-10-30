<?php
/**
 * @APP@
 *
 * @package Page
 */
require_once 'App.php';

/**
 * Untitledページ
 *
 * <pre>
 * </pre>
 *
 * @package Page
 * @author  $Author:$
 * @version SVN: Release: $Id:$
 */
class Page_Index extends App_Page
{

    /**
     * インジェクト
     *
     * @return void
     */
    public function onInject()
    {
        parent::onInject();
    }

    /**
     * 初期化
     *
     * @return void
     */
    public function onInit(array $args)
    {
        // RSS resource
        $uri = 'http://rss.excite.co.jp/rss/excite/odd';
        $options['pager'] = 5;
        $params = array('uri' => $uri, 'values' => array(), 'options' => $options);
        $this->_resource->read($params)->set('news');
        $this->set('time', date('n/j H:i'));
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
}
$options = array('cache' => array('type' => 'init', 'life' => 10));
App_Main::run('Page_Index', $options);
