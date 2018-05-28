<?php
/**
 * Created by IntelliJ IDEA.
 * User: lkzcm
 * Date: 2017/8/25
 * Time: 17:10
 */

class FanweSessionHandler
{
    private $savePath;
    private $mem;  //Memcache使用
    private $prefix;

    function open($savePath, $sessionName)
    {
        $this->savePath = APP_ROOT_PATH.$GLOBALS['distribution_cfg']['SESSION_FILE_PATH'];
        $this->mem=ayy::$app->session_redis;
        $this->prefix = $GLOBALS['distribution_cfg']['REDIS_PREFIX'];

        return true;
    }

    function close()
    {
        return true;
    }

    function read($id)
    {
        $sess_id = "sess_".$id;
        return $this->mem->get("$this->prefix.$this->savePath/$sess_id");
    }

    function write($id, $data)
    {

        $sess_id = "sess_".$id;
        return $this->mem->set("$this->prefix.$this->savePath/$sess_id",$data,SESSION_TIME);
    }

    function destroy($id)
    {

        $sess_id = "sess_".$id;
        return $this->mem->delete("$this->prefix.$this->savePath/$sess_id");
        return true;
    }

    function gc($maxlifetime)
    {
        return true;
    }
}