<?php
/**
 * Created by IntelliJ IDEA.
 * User: lkzcm
 * Date: 2018/5/11
 * Time: 10:56
 */

namespace unit\extend;

use PDO;
use PDOStatement;

class PdoDb
{
    protected $settings = [];
    public $prefix;
    /**
     * @var PDO the application instance
     */
    protected $db;
    /**
     * @var PDOStatement the application instance
     */
    protected $sth;

    function __construct($array)
    {
        $this->settings = array(
            'dbhost' => $array["DB_HOST"],
            'dbuser' => $array["DB_USER"],
            'dbpw' => $array["DB_PWD"],
            'dbname' => $array["DB_NAME"],
            'charset' => $array["charset"],
        );
        $this->prefix=$array["prefix"];
        $this->connect();
    }

    function connect()
    {
        $this->db = new PDO("mysql:host={$this->settings['dbhost']}
        ;dbname={$this->settings['dbname']}",
            $this->settings['dbuser'],
            $this->settings['dbpw'], array(PDO::ATTR_PERSISTENT => true)
        );
        if (!$this->settings['charset'])
            $this->settings['charset'] = "utf8";
        $this->db->exec("set names {$this->settings['charset']}");
    }

    function ping()
    {
        $status = $this->db->getAttribute(PDO::ATTR_SERVER_INFO);
        if (!$status)
            $this->connect();
    }

    /*
     * param_type  1为:param模式
     */
    function query($sql, $param = [], $param_type = 1)
    {
        $this->ping();
        if ($param_type == 1)
            $this->sth = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        else
            $this->sth = $this->db->prepare($sql);
        $this->sth->execute($param);
    }

    function getRow($sql, $param = [])
    {
        $this->query($sql, $param);
        $result = $this->sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function getAll($sql, $param = [])
    {
        $this->query($sql, $param);
        $result = $this->sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}