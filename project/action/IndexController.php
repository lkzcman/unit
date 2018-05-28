<?php
/**
 * Created by IntelliJ IDEA.
 * User: lkzcm
 * Date: 2017/9/4
 * Time: 19:46
 */
class IndexController extends baseController
{
    public function index(){

        var_dump(ayy::$app->redisdb);
        var_dump(ayy::$app->db);
    }
}