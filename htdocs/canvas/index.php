<?php
/**
 * @APP@
 *
 * @package Page
 */
require_once 'App.php';

/**
 * Canvas
 *
 * Facebook Integration > キャンバスページURL
 *
 * @package Page
 * @author  HAYASHI Ryo<ryo@spais.co.jp>
 * @version 0.0.1
 */
class Page_Canvas_Index extends App_Page
{
    /**
     * インジェクト
     *
     * @return void
     */
    public function onInject()
    {
        parent::onInject();

        $session = BEAR::dependency('App_Fb')->getSession();
        if(empty($session)){ // Not connect
            $this->header->redirect('/connect');
        }

        $me = $this->_resource->read(array('uri' => 'graph://me'))->getBody();
        if(empty($me)){
            $this->header->redirect('/connect');
        }
        $this->injectArg('me', $me);
        $this->injectArg('query', getenv('QUERY_STRING'));
    }

    /**
     * 初期化
     *
     * @required me
     * @return void
     */
    public function onInit(array $args)
    {
        $this->set('query', $args['query']);
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

    public function onException(Exception $e){
        $msg = $e->getMessage();
        if($msg === '0 Error validating access token.'){
            // access token の有効期限が切れたので connect し直す
            $this->header->redirect('/connect');
        }else{
            parent::onException($e);
        }
    }
}
$options = array('cache' => array('type' => 'init', 'life' => 0));
App_Main::run('Page_Canvas_Index', $options);