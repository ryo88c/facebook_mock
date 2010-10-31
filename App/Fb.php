<?php
/**
 *
 * Facebook クラスのファクトリー
 *
 * $facebook = BEAR::factory('App_Fb');
 *
 * @author HAYASHI Ryo<ryo@spais.co.jp>
 * @version 0.0.1
 */
class App_Fb extends BEAR_Factory{

    function factory(){
        return new App_Facebook(array(
          'appId'  => $this->_config['info']['appId'],
          'secret' => $this->_config['info']['secret'],
          'cookie' => true
        ));
    }

    function __construct(array $config){
        include_once(_BEAR_APP_HOME.'/App/facebook-php-sdk/src/facebook.php');
        parent::__construct($config);
    }
}