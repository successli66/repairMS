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
     * 获得二维码(用ticket换取二维码)
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

    /**
     * 信息响应
     */
    public function responseMsg() {
        $postStr = $GLOBALS['HTTP_RAW_POST_DATA'];
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        switch ($postObj->MsgType) {
            case 'event':
                $this->_doEvent($postObj);
                break;
            case 'text':
                $this->_doText($postObj);
                break;
            case 'image':
                $this->_doImage($postObj);
                break;
            case 'voice':
                $this->_doVoice($postObj);
                break;
            case 'video':
                $this->_doVideo($postObj);
                break;
            case 'location':
                $this->_doLocation($postObj);
                break;
            case 'click':
                $this->_doClick($postObj);
                break;
            default: exit;
        }
    }

    /**
     * 事件处理，订阅和取消
     * @param type $postObj
     */
    private function _doEvent($postObj) {
        switch ($postObj->Event) {
            case 'subscribe':
                $this->_doSubscribe($postObj);
                break;
            case 'unsubscribe':
                $this->_doUnsubscribe($postObj);
                break;
            default :;
        }
    }

    /**
     * 订阅处理
     * @param type $postObj
     */
    private function _doSubscribe($postObj) {
        $tpltext = '<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[%s]]></Content>
        </xml>';
        $str = sprintf($tpltext, $postObj->FromUserName, $postObj->ToUserName, time(), '欢迎关注！'); //sprintf用于替换%s
        echo $str;
    }

    private function _doUnsubscribe($postObj) {
        ; //把用户从数据库中删除
    }

    /**
     * 私有方法文本响应
     * @param type $postObj
     */
    private function _doText($postObj) {
        $fromUserName = $postObj->FromUserName;
        $toUserName = $postObj->ToUserName;
        $keyword = trim($postObj->Content);
        $time = time();
        $textTpl = '<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>
            <Content><![CDATA[%s]]></Content>
        </xml>';
        if (!empty($keyword)) {
//            $data = "chat=" . $keyword;调用外部回复，实现问答
//            $contentStr = $this->_request("http://www.xiaodoubi.com/bot/chat.php", false, "post", $data);
            if ($keyword == "hello")
                $contentStr = "Welcome to wechat  PHP 39 world!";
            if ($keyword == "PHP")
                $contentStr = "最流行的网页编程语言！";
            if ($keyword == "JAVA")
                $contentStr = "较流行的网页编程语言！";
            $msgType = 'text';
            $textStr = sprintf($textTpl, $fromUserName, $toUserName, $time, $msgType, $contentStr);
            echo $textStr;
        }
    }

    /**
     * 私有方法点击响应
     * @param type $postObj
     */
    private function _doClick($postObj) {
        $list = '<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[%s]]></MsgType>
        <ArticleCount>%s</ArticleCount>
        <Articles>
        %s
        </Articles>
        </xml>';
        $item = '<item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
        </item>';
        $news = array(
            array('title' => '曝郑智进亚洲足球先生三甲 恒大夺亚冠或可当选 ',
                'description' => '北京时间11月9日消息，据《体坛周报》报道，2015年“亚洲足球先生”即将于本月底揭晓，中国国家队和广州恒大队双料队长郑智已进入最后的3名候选人名单，如果恒大本赛季最终夺得亚冠，郑智将有很大可能第二度夺得这项荣誉。',
                'picurl' => 'http://k.sinaimg.cn/n/transform/20151109/rWfJ-fxknius9759492.jpg/w5705ff.jpg',
                'url' => 'http://sports.sina.com.cn/china/afccl/2015-11-09/doc-ifxknius9759639.shtml'),
            array('title' => ' 西甲-C罗哑火J罗复出 皇马2-3遭逆转首负丢榜首 ',
                'descrption' => '北京时间11月9日03：30（西班牙当地时间8日20：30），2015/16赛季西班牙足球甲级联赛第11轮一场焦点战在皮斯胡安球场展开角逐，皇家马德里客场2比3不敌塞维利亚，拉莫斯倒钩进球后伤退，因莫比莱、巴内加和洛伦特连续进球，贝尔助攻J罗伤停补时扳回一城。皇马遭遇赛季首负丢失榜首。',
                'picurl' => 'http://k.sinaimg.cn/n/transform/20151109/sFo8-fxknutf1614882.jpg/w570151.jpg',
                'url' => 'http://sports.sina.com.cn/g/laliga/2015-11-09/doc-ifxknutf1614642.shtml'),
            array('title' => ' 西甲-C罗哑火J罗复出 皇马2-3遭逆转首负丢榜首 ',
                'descrption' => '北京时间11月9日03：30（西班牙当地时间8日20：30），2015/16赛季西班牙足球甲级联赛第11轮一场焦点战在皮斯胡安球场展开角逐，皇家马德里客场2比3不敌塞维利亚，拉莫斯倒钩进球后伤退，因莫比莱、巴内加和洛伦特连续进球，贝尔助攻J罗伤停补时扳回一城。皇马遭遇赛季首负丢失榜首。',
                picurl => 'http://k.sinaimg.cn/n/transform/20151109/sFo8-fxknutf1614882.jpg/w570151.jpg',
                url => 'http://sports.sina.com.cn/g/laliga/2015-11-09/doc-ifxknutf1614642.shtml')
        );
        $count = count($news);
        for ($i = 0; $i < $count; $i++) {
            $it = sprintf($item, $news[$i]['title'], $news[$i]['description'], $news[$i]['picurl'], $news[$i]['url']);
        }
        $content = sprintf($list, $postObj->FromUserName, $postObj->ToUserName, time(), $count, $it);
        echo $content;
    }

    /**
     * 私有方法位置响应
     * @param type $postObj
     */
    private function _doLocation($postObj) {
        $textTpl = '<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>
            <Content><![CDATA[%s]]></Content>
        </xml>';
        $str = sprintf($textTpl, $postObj->FromUserName, $postObj->ToUserName, time(), 'text', '您所在的位置是：东经' . $postObj->Latitude . '，北纬：' . $postObj->Latitude . '。');
        echo $str;
    }

    /**
     * 查询菜单
     * @return type
     */
    public function _queryMenu() {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token=' . $this->_getAccesstoken();
        $menue = $this->_request($url);
        return $menue;
    }

    /**
     * 删除菜单
     * 会删除所有自定义菜单
     */
    public function _deleteMenu() {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=' . $this->_getAccesstoken();
        $result = $this->_request($url);
        $result = json_decode($result);
        if ($result->errcode == 0) {
            echo '删除菜单成功！';
        }
    }

    /**
     * 创建菜单
     */
    public function _createMenu() {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=' . $this->_getAccesstoken();
        $result = $this->_request($url, TRUE, 'post', $menu);
        $result = json_decode($result);
        if ($result->errcode == 0) {
            echo '菜单创建成功！';
        }
    }

    /**
     * 获得用户列表
     * 返回一个一位数组
     * @return type
     */
    public function _getUserList() {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token=' . $this->_getAccesstoken() . '&next_openid=';
        $content = $this->_request($url);
        $content = json_decode($content);
        $user = $content->data->openid;
        return $user;
    }

    /**
     * 群发消息
     * @param type $content
     */
    public function _sendAll($content) {
        $tpl = '{
            "touser":[
            %s
            ],
            "msgtype": "text",
            "text": { "content": "%s"}
        }';
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=' . $this->_getAccesstoken();
        $users = $this->_getUserList();
        foreach ($users as $k => $v) {
            $user .= '"' . $v . '"';
            if ($k < count($users) - 1) {
                $user .= ',';
            }
        }
        $data = sprintf($tpl, $user, $content);
        $result = $this->_request($url, TRUE, 'post', $data);
        $result = json_decode($result);
        if ($result->errcode == 0) {
            echo '发送成功！';
        }
    }

    /**
     * 添加素材
     * @param type $type
     * @param type $file
     */
    public function _addMedia($type,$file) {
        $url = 'https://api.weixin.qq.com/cgi-bin/media/upload?access_token=' . $this->_getAccesstoken() . '&type=' . $type;
        $data['type'] = $type;
        $data['media'] = '@' . $file;
        $result = $this->_request($url, true, "post", $data);
        echo $result;
    }

}
