<?php

class WeChat {

    private $_appid;
    private $_appsecret;
    private $_token;

    public function __construct($appid, $appsecret, $token) {
        $this->_appid = $appid;
        $this->_appsecret = $appsecret;
        $this->_token = $token;
    }

    /**
     * 设置curl访问
     * @param type $curl
     * @param type $https
     * @param type $method
     * @param type $data
     * @return type
     */
    private function _request($curl, $https = true, $method = 'get', $data = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $curl);    //设置要访问的url
        curl_setopt($ch, CURLOPT_HEADER, FALSE);  //设置不需要头信息
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); //只获取页面内容，但不输出
        if ($https) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); //不做服务器认证
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); //不做客户端认证
        }
        if ($method == 'post') {
            curl_setopt($ch, CURLOPT_POST, TRUE);  //设置请求是post
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //设置post请求数据
        }
        $str = curl_exec($ch);
//        if ($str === FALSE) {
//            echo "CURL Error:" . curl_error($ch);
//        }
        curl_close($ch);
        return $str;
    }

    /**
     * 获得accesstoken
     * @return type
     */
    private function _getAccesstoken() {
        $file = './accesstoken';
        if (file_exists($file)) {
            $content = file_get_contents($file);
            $content = json_decode($content);
            if (time() - filemtime($file) < $content->expires_in) {
                return $content->access_token;
            }
            $curl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $this->_appid . "&secret=" . $this->_appsecret;
            $content = $this->_request($curl);
            file_put_contents($file, $content);
            $content = json_decode($content);
            return $content->access_token;
        }
    }

    /**
     * 校验签名
     * @return boolean
     */
    private function checkSignature() {
        $signature = $_GET('signature');
        $timestamp = $_GET('timestamp');
        $nonce = $_GET('nonce');
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $signature) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 检测是否连接微信成功
     */
    public function valid() {
        $echoStr = $_GET('echostr');
        if ($this->checkSignature()) {
            echo $echoStr;
            exit();
        }
    }

    /**
     * 获得二维码的ticket
     * @param type $expires_seconds
     * @param type $type
     * @param type $scene
     * @return type
     */
    public function _getTicket($expires_seconds = 604800, $type = 'tempt', $scene = 1) {
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=" . $this->_getAccesstoken();
        if ($type == 'tempt') {
            $data = '{"expire_seconds":' . $expires_seconds . ', "action_name": "QR_SCENE", "action_info": {"scene":{"scene_id":' . $scene . '}}}';
        } else {
            $data = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": ' . $scene . '}}}';
        }
        return $this->_request($url, TRUE, 'post', $data);
    }

    /**
     * 获得二维码
     * @param type $expires_seconds
     * @param type $type
     * @param type $scene
     * @return type
     */
    public function _getQRCode($expires_seconds, $type, $scene) {
        $file = './' . $type . $scene . '.jpg';
        if (file_exists($file)) {
            if (time() - filemtime($file) < $expires_seconds) {
                return file_get_contents($file);
            } else {
                $content = json_decode($this->_getTicket($expires_seconds, $type, $scene)); //需要jsonDecode
                $ticket = urlencode($content->ticket);
                $curl = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . $ticket;
                $image = $this->_request($curl);
                file_put_contents($file, $image);
                return $image;
            }
        }
    }

}
