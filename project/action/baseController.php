<?php

class baseController
{
    public function __construct()
    {

    }

    public function __destruct()
    {

    }


    protected function error($str,$status=0)
    {
        $data["status"] = $status;
        $data["error"] = $str;
        ajax_return($data);
    }

    protected function success($data)
    {
        $result["status"] = 1;
        $result["data"] =$data;
        ajax_return($result);
    }

    protected function check_parameter($array)
    {
        $param = require(project_dictory . '/common/param.php');
        foreach ($array as $value) {
            if (is_array($value)) {
                $field = $value["field"];
                $comments = $value["comments"];
            } else {
                $field = $value;
                $comments = $value;
            }
            if ($param[$field]) {
                if(isset($param[$field]["comment"])){
                    $comments=$param[$field]["comment"];
                }
                if (isset($param[$field]["min_length"])) {
                    if(strlen($_REQUEST[$field])<$param[$field]["min_length"]){
                        $this->error($comments."最小长度为".$param[$field]["min_length"]);
                    }
                }
                if (isset($param[$field]["max_length"])) {
                    if(strlen($_REQUEST[$field])>$param[$field]["max_length"]){
                        $this->error($comments."最大长度为".$param[$field]["max_length"]);
                    }
                }
                if(isset($param[$field]["require"])){
                    if($param[$field]["require"]) {
                        if (!$_REQUEST[$field]) {
                            $this->error("请填写" . $comments . "有效值");
                        }
                    }
                }

                if(isset($param[$field]["default_value"])&&!$_REQUEST[$field]){
                    $this->$field=$param[$field]["default_value"];
                }else{
                    if(isset($param[$field]["type"])){
                        if($param[$field]["type"]=="int"){
                            $_REQUEST[$field]=intval($_REQUEST[$field]);
                        }
                    }
                }
                if ($param[$field]["function"]) {
                    $function = $param[$field]["function"];
                    if (function_exists($function)) {
                        if( $param[$field]["param"]){
                            $this->$field = $function($_REQUEST[$field]);
                        }else{
                            $this->$field = $function();
                        }
                    } else {
                        if( $param[$field]["param"]){
                            $this->$field = $this->$function($_REQUEST[$field]);
                        }else{
                            $this->$field = $this->$function();
                        }

                    }
                }
                if(!$this->$field){
                    $this->$field = $_REQUEST[$field];
                }
            } else {
                if (!isset($_REQUEST[$field])) {
                    $this->error("请输入参数- $comments");
                } else {
                    $this->$field = $_REQUEST[$field];
                }
            }
        }
    }

    function curlPost($url, $data = '')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);//这个值不设置有时会出现error 35情况
        return curl_exec($ch);
    }
}