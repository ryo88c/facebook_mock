<?php
/**
 * Graph API へのリクエストを処理する graph:// スキーマの executer
 * @author HAYASHI Ryo<ryo@spais.co.jp>
 * @version
 */
class App_Resource_Execute_Graph extends BEAR_Resource_Execute_Adaptor{

    /**
     * @var Facebook
     */
    private $_fb;

    /**
     * Requester
     */
    function request(){
        $uri = str_replace('graph://', '/', $this->_config['uri']);
        return $this->_fb->api($uri, $this->_config['values']);
    }

    /**
     * Constructor
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->_fb = BEAR::factory('App_Fb');
        parent::__construct($config);
    }
}