<?php
/**
 * Facebook クラスを継承して並列リクエスト処理を実装
 * @author HAYASHI Ryo<ryo@spais.co.jp>
 * @version 0.0.1
 */
class App_Facebook extends Facebook{

    /**
     * Graph API に並列リクエストする
     * @param array $requests
     */
    function multiRead(array $requests){
        $token = $this->getAccessToken();
        $chs = array();
        $mch = curl_multi_init();
        foreach($requests as $request){
            $request = array_merge(array('url' => null, 'method' => 'GET', 'params' => array()), $request);
            extract($request);
            $params['method'] = $method;
            $params['access_token'] = $token;
            $url = $this->getUrl('graph', $url);
            $ch = curl_init();

            $opts = self::$CURL_OPTS;
            if ($this->useFileUploadSupport()) {
                $opts[CURLOPT_POSTFIELDS] = $params;
            } else {
                $opts[CURLOPT_POSTFIELDS] = http_build_query($params, null, '&');
            }
            $opts[CURLOPT_URL] = $url;

            // disable the 'Expect: 100-continue' behaviour. This causes CURL to wait
            // for 2 seconds if the server does not support this header.
            if (isset($opts[CURLOPT_HTTPHEADER])) {
                $existing_headers = $opts[CURLOPT_HTTPHEADER];
                $existing_headers[] = 'Expect:';
                $opts[CURLOPT_HTTPHEADER] = $existing_headers;
            } else {
                $opts[CURLOPT_HTTPHEADER] = array('Expect:');
            }

            curl_setopt_array($ch, $opts);
            curl_multi_add_handle($mch, $ch);
            $chs[] = $ch;
        }

        $running = null;
        do{curl_multi_exec($mch, $running);}while($running > 0);

        $results = array();
        foreach($chs as $ch){
            $result = curl_exec($ch);
            if (curl_errno($ch) == 60) { // CURLE_SSL_CACERT
                self::errorLog('Invalid or no certificate authority found, using bundled information');
                curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/fb_ca_chain_bundle.crt');
                $result = curl_exec($ch);
            }

            if ($result === false) {
                $e = new FacebookApiException(array(
                'error_code' => curl_errno($ch),
                'error'      => array(
                    'message' => curl_error($ch),
                    'type'    => 'CurlException',
                ),
                ));
                curl_close($ch);
                throw $e;
            }
            curl_close($ch);
            $results[] = json_decode($result, true);
        }
        return $results;
    }
}