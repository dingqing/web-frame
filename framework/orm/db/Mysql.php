<?php
namespace Framework\Orm\Db;

use Framework\Orm\DB;
use Framework\Exceptions\CoreHttpException;
use PDO;

/**
 * mysql实体类
 */
class Mysql
{
    private $dbhost   = '';
    private $dbname   = '';
    private $dns      = '';
    private $username = '';
    private $password = '';
    private $pdo = '';
    private $pdoStatement = '';

    public function __construct(
        $dbhost   = '',
        $dbname   = '',
        $username = '',
        $password = '')
    {
        $this->dbhost   = $dbhost;
        $this->dbname   = $dbname;
        $this->dsn      = "mysql:dbname={$this->dbname};host={$this->dbhost};";
        $this->username = $username;
        $this->password = $password;

        $this->connect();
    }

    private function connect()
    {
        $this->pdo = new PDO(
            $this->dsn,
            $this->username,
            $this->password
        );
    }

    /**
     * 魔法函数__get
     */
    public function __get($name = '')
    {
        return $this->$name;
    }

    /**
     * 魔法函数__set
     */
    public function __set($name = '', $value = '')
    {
        $this->$name = $value;
    }

    /**
     * @param  DB     $db DB instance
     * @return array
     */
    public function findOne(DB $db)
    {
        $this->pdoStatement = $this->pdo->prepare($db->sql);
        $this->bindValue($db);
        $this->pdoStatement->execute();
        return $this->pdoStatement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param  DB     $db DB instance
     * @return array
     */
    public function findAll(DB $db)
    {
        $this->pdoStatement = $this->pdo->prepare($db->sql);
        $this->bindValue($db);
        $this->pdoStatement->execute();
        return $this->pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param  DB     $db DB instance
     * @return string
     */
    public function save(DB $db)
    {
        $this->pdoStatement = $this->pdo->prepare($db->sql);
        $this->bindValue($db);
        $res = $this->pdoStatement->execute();
        if (! $res) {
            return false;
        }
        return $db->id  = $this->pdo->lastInsertId();
    }

    /**
     * @param  DB     $db DB instance
     * @return boolean
     */
    public function delete(DB $db)
    {
        $this->pdoStatement = $this->pdo->prepare($db->sql);
        $this->bindValue($db);
        $this->pdoStatement->execute();
        return $this->pdoStatement->rowCount();
    }

    /**
     * @param  DB     $db DB instance
     * @return boolean
     */
    public function update(DB $db)
    {
        $this->pdoStatement = $this->pdo->prepare($db->sql);
        $this->bindValue($db);
        return $this->pdoStatement->execute();
    }

    /**
     * @param  DB     $db DB instance
     * @return boolean
     */
    public function query(DB $db)
    {
        $res = [];
        foreach ($this->pdo->query($db->sql, PDO::FETCH_ASSOC) as $v) {
            $res[] = $v;
        }
        return $res;
    }

    /**
     * @param  DB     $db DB instance
     * @return void
     */
    public function bindValue(DB $db)
    {
        if (empty($db->params)) {
            return;
        }
        foreach ($db->params as $k => $v) {
            $this->pdoStatement->bindValue(":{$k}", $v);
        }
    }

    public function beginTransaction()
    {
        $this->pdo->beginTransaction();
    }
    public function commit()
    {
        $this->pdo->commit();
    }
    public function rollBack()
    {
        $this->pdo->rollBack();
    }
}
