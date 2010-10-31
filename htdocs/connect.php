<?php
require_once 'App.php';
/**
 * Connect page
 *
 * @package Page
 * @author  HAYASHI Ryo <ryo@spais.co.jp>
 * @version 0.0.1
 */
class Page_Connect extends App_Page
{

    public function onInject()
    {
        parent::onInject();
    }

    public function onInit(array $args)
    {
        $loginUrl = BEAR::dependency('App_Fb')->getLoginUrl(array('next' => 'http://'.getenv('HTTP_HOST').'/canvas/',
            'req_perms' => $this->_config['info']['req_perms']));
        $this->set('loginUrl', $loginUrl);
    }

    public function onOutput()
    {
        $this->display();
    }
}
$options = array('cache' => array('type' => 'init', 'life' => 10));
App_Main::run('Page_Connect', $options);
