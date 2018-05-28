<?php

// 微信处理类
set_time_limit(30);
class Qrcode2{
    //构造方法
    static $qrcode_url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?";
    static $token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&";
    static $qrcode_get_url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?";
    //生成二维码
    public function getEwm($fqid,$type = 1){
        $ACCESS_TOKEN = $this->getToken(wx_appid,wx_secret);
        $url = $this->getQrcodeurl($ACCESS_TOKEN,$fqid,$type);
        return $this->DownLoadQr($url,time());
    }

    protected function getQrcodeurl($ACCESS_TOKEN,$fqid,$type = 1){
        $url = self::$qrcode_url.'access_token='.$ACCESS_TOKEN;
        if($type == 1){
            //生成永久二维码
            $qrcode= '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": '.$fqid.'}}}';
        }else{
            //生成临时二维码
            $qrcode = '{"expire_seconds": 1800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": '.$fqid.'}}}';
        }
        $result = $this->http_post_data($url,$qrcode);
        $oo = json_decode($result[1]);
        if(!$oo->ticket){
            $this->ErrorLogger('getQrcodeurl falied. Error Info: getQrcodeurl get failed');
            exit();
        }
        $url = self::$qrcode_get_url.'ticket='.$oo->ticket.'';
        return $url;

    }

    protected function getToken($appid,$secret){
        $ACCESS_TOKEN = file_get_contents(self::$token_url."appid=$appid&secret=$secret");
        $ACCESS_TOKEN = json_decode($ACCESS_TOKEN);
        $ACCESS_TOKEN = $ACCESS_TOKEN->access_token;
        return $ACCESS_TOKEN;
    }
    protected function http_post_data($url, $data_string) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json; charset=utf-8',
                'Content-Length: ' . strlen($data_string))
        );
        ob_start();
        curl_exec($ch);
        if (curl_errno($ch)) {
            $this->ErrorLogger('curl falied. Error Info: '.curl_error($ch));
        }
        $return_content = ob_get_contents();
        ob_end_clean();
        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return array($return_code, $return_content);
    }
    //下载二维码到服务器
    protected function DownLoadQr($url,$filestring){
        if($url == ""){
            return false;
        }
        $filename = $filestring.'.jpg';
        ob_start();
        readfile($url);
        $img=ob_get_contents();
        ob_end_clean();
        $size=strlen($img);
        $fp2=fopen('./Uploads/qrcode/'.$filename,"a");
        if(fwrite($fp2,$img) === false){
            $this->ErrorLogger('dolwload image falied. Error Info: 无法写入图片');
            exit();
        }
        fclose($fp2);
        return './Uploads/qrcode/'.$filename;
    }

    private function ErrorLogger($errMsg){
        $logger = fopen('./ErrorLog.txt', 'a+');
        fwrite($logger, date('Y-m-d H:i:s')." Error Info : ".$errMsg."\r\n");
    }
}