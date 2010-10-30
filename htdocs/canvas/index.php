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
    }

    /**
     * 初期化
     *
     * @return void
     */
    public function onInit(array $args)
    {
        // Create our Application instance (replace this with your appId and secret).
        $facebook = BEAR::factory('App_Fb');

        // We may or may not have this data based on a $_GET or $_COOKIE based session.
        //
        // If we get a session here, it means we found a correctly signed session using
        // the Application Secret only Facebook and the Application know. We dont know
        // if it is still valid until we make an API call using the session. A session
        // can become invalid if it has already expired (should not be getting the
        // session back in this case) or if the user logged out of Facebook.
        $session = $facebook->getSession();

        $me = $uid = null;
        // Session based API call.
        if ($session) {
            $uid = $facebook->getUser();
            $me = $facebook->api('/me');
        }

        // login or logout url will be needed depending on current user state.
        $loginUrl = $logoutUrl = null;
        if ($me) {
          $logoutUrl = $facebook->getLogoutUrl();
        } else {
          $loginUrl = $facebook->getLoginUrl();
        }

        // This call will always work since we are fetching public data.
        $naitik = $facebook->api('/naitik');

        $appId = $facebook->getAppId();
        $encodedSession = json_encode($session);
        $this->set(compact('loginUrl', 'logoutUrl', 'appId', 'encodedSession', 'me', 'uid', 'naitik'));
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
App_Main::run('Page_Canvas_Index', $options);