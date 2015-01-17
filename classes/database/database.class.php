<?php

class Database
{
    private $conn = false;
    private $result = false;
    private $context = false;
    private $contexts = false;


    public function __construct($context = "default") {
        $this->contexts = json_decode(file_get_contents(CLASS_PATH."database/database.conf.json"), true);
        $this->setContext($context);
    }

    public function setContext($context) {
        if (isset($this->contexts[$context]))
            $this->context = $context;
        else {
            $this->context = false;
            throw new Exception ('Failed to  connect - invalid database context "'.$context.'"');
        }
    }

    public function connect()
    {

        $db = $this->contexts[$this->context];

        $this->conn = new PDO("mysql:host=".$db["host"].";dbname=".$db["database"].";",$db["user"], $db["pass"] );
        $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->result = false;
    }

    public function query($sql, $params = false)
    {
        $this->connect();

        $this->result = $this->conn->prepare($sql);

        try {
            if ($params)
                $this->result->execute($params);
            else
                $this->result->execute();
        } catch (PDOException $e) {
            echo '<pre>'.$e->getMessage()."\n".$e;
            print_r($params);
            echo '</pre>';

        }

        return $this->result->rowCount();

    }

    public function getArray($single = false)
    {
        $return = array();
        try {
            while ($r = $this->result->fetch())
                $return[] = $r;

            if ($single)
            {
                if ($this->result->rowCount() == 0)
                    return false;

                $return = $return[0];
            }

            return $return;
        }
        catch (PDOException $e)
        {
            return false;
        }
    }

    public function getLastID()
    {
        if ($this->result)
            return $this->conn->lastInsertId();
        return false;
    }
}