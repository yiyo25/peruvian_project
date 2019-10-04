<?php

class ORM extends Database {

    private static $cnx;
    private static $primary_key;

    function __construct() {
        self::$primary_key = $this->_primary_key;
        //self::getConnection();
    }

    public static function getConexion() {
        self::$cnx = Database::conectar();
    }

    public static function getDesconectar() {
        self::$cnx = null;
    }

    public static function all() {
        $query = "SELECT * FROM " . static ::$table;
        //echo $query;exit;
        $class = get_called_class();
        self::getConexion();
        $res = self::$cnx->prepare($query);
        $res->execute();
        //var_dump($res->execute());exit;
        $arr = array();
        foreach ($res as $row) {
            $obj = new $class($row);
            array_push($arr, $obj);
        }
        self::getDesconectar();
        return $arr;
    }

    public static function where($columna, $valor) {

        /*if(is_array($columna)){
            $array_col = array();
            foreach ($columna as $key => $value) {
                foreach ($value as $key1 => $value1) {
                    $array_col[] = $key1 ."='".$value1."'";
                }
            }
        }
        $columna = implode(" and ", $array_col);*/

        $query = "SELECT * FROM " . static ::$table . " WHERE " . $columna . " = :" . $columna;
        $class = get_called_class();
        self::getConexion();
        $res = self::$cnx->prepare($query);
        $res->bindParam(":" . $columna, $valor);
        $res->execute();
        $obj = array();
        foreach ($res as $row) {
            $obj[] = new $class($row);
        }
        self::getDesconectar();
        return $obj;
    }

    public static function find($id) {
        $resultado = self::where(static ::$_primary_key, $id);
        if (count($resultado)) {
            return $resultado[0];
        } else {
            return array();
        }
    }

    public function save() {
        $values = get_object_vars($this);
        $filtered = null;

        foreach ($values as $key => $value) {
            if ($value !== null && $value !== '' && strpos($key, 'obj_') === false && $key !== 'id') {
                if ($value === false) {
                    $value = 0;
                }
                $filtered[$key] = $value;
            }
        }
        $columns = array_keys($filtered);

        if ($this->id) {
            $columns = join(" = ?, ", $columns);
            $columns .= ' = ?';
            $query = "UPDATE " . static::$table . " SET $columns WHERE id =" . $this->id;
        } else {
            $params = join(", ", array_fill(0, count($columns), "?"));
            $columns = join(", ", $columns);
            $query = "INSERT INTO " . static::$table . " ($columns) VALUES ($params)";
        }

        $result = self::$cnx->execute($query, null, $filtered);

        if ($result) {
            $result = array('error' => false, 'message' => $this->lastInsertId());
        } else {
            $result = array('error' => true, 'message' => $this->errorInfo());
        }

        return $result;
    }

    public function __call($method, $args) {
        echo "$method =>  este método no está definido y/o implementado<br>";
    }

}

?>