<?php
/**
 * @APP@
 *
 * @package Page
 */
require_once 'App.php';

/**
 * 抽出リクエストの処理(AJAX)
 *
 * @package Page
 * @author  HAYASHI Ryo<ryo@spais.co.jp>
 * @version 0.0.1
 */
class Page_Cooccurrence extends App_Page
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
            $this->onException(new Exception('Not connect'));
        }

        $me = $this->_resource->read(array('uri' => 'graph://me'))->getBody();
        $this->injectArg('me', $me);
    }

    /**
     * required me
     */
    public function onInit(array $args){
        $fb = BEAR::dependency('App_Fb');
        $_likes = $this->_resource->read(array('uri' => sprintf('graph://%d/likes', $args['me']['id'])))->getBody();
        $myLikes = array();
        foreach($_likes['data'] as $act){
            $myLikes[] = $act['id'];
        }
        $myCnt = count($myLikes);

        $rows = $_friends = $requests = array();
        $friends = $this->_resource->read(array('uri' => sprintf('graph://%d/friends', $args['me']['id'])))->getBody();
        foreach($friends['data'] as $i => $friend){
            //if($i > 5) break;
            $requests[] = array('url' => sprintf('/%d/likes', $friend['id']));
        }
        $results = $fb->multiRead($requests);

        $requests = array();
        foreach($results as $i => $_likes){
            if(empty($_likes['data'])) continue;
            $friendLikes = array();
            $likes = $myLikes;
            foreach($_likes['data'] as $act){
                $friendLikes[] = $act['id'];
                if(in_array($act['id'], $likes)) continue;
                $likes[] = $act['id'];
            }

            $and = $or = 0;
            foreach($likes as $like){
                if(in_array($like, $friendLikes) || in_array($like, $myLikes)) $or ++;
                if(in_array($like, $friendLikes) && in_array($like, $myLikes)) $and ++;
            }
            if($and / $or <= 0) continue;
            $rows[$friends['data'][$i]['id']] = $and / $or;
            $requests[] = array('url' => '/'.$friends['data'][$i]['id']);
        }

        $_profiles = $fb->multiRead($requests);
        $profiles = array();
        foreach($_profiles as $profile){
            $profiles[$profile['id']] = $profile;
        }

        $result = array();
        arsort($rows, SORT_NUMERIC);
        foreach($rows as $friendId => $row){
            $result[] = array('name' => $profiles[$friendId]['name'], 'link' => $profiles[$friendId]['link'], 'cooc' => $row);
        }

        $this->set('result', $result);
    }

    /**
     * 出力
     *
     * @return void
     */
    public function onOutput()
    {
        $this->output('json');
    }

    public function onException(Exception $e){
        if(preg_match('/^\(#803\)/', $e->getMessage())){
            // いない userid 指定してるっぽいのでスルーする
        }else{
            $this->set('error', $e->getMessage());
            $this->output('json');
            exit;
        }
    }
}
$options = array('cache' => array('type' => 'init', 'life' => 0));
App_Main::run('Page_Cooccurrence', $options);