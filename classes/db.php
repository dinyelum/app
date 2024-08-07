<?php
trait Db {
    private static $query;
    private static $extra;
    private static $query_type;
    private static $update_arr;
    private static $conn;
    private static $instance;

    private function conn() {
        if(!self::$instance) {
            self::$instance = new Self();
        }

        if(!self::$conn) {
            try {
                // self::$conn = new PDO('mysql:host=server; dbname=db', user, pass);
                self::$conn = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME, DB_USER, DB_PASS);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                // if($transaction) {
                //     self::$conn->beginTransaction();
                // }
            } catch (PDOEXCEPTION $e) {
                // if($transaction) {
                //     self::$conn->rollback();
                // }
                error_log('Connection error: '.$e->getMessage());
            }
        }
        return self::$instance;
    }

    public function select($columns='*', $alias='') {
        $this->conn();
        self::$query_type = 'select';
        $as = $alias ? "as $alias" : '';
        self::$query = "select $columns from ".self::$table." $as ";
        // self::$extra = $extra;
        return self::$instance;
    }

    public function join($jointype, $table, $cols, $alias='') {
        $as = $alias ? "as $alias" : '';
        self::$query .= " $jointype $table $as on $cols";
        return self::$instance;
    }

    public function all($extra='') {
        self::$query .= " $extra";
        return $this->run();
    }

    public function insert(array $colsandvals, $returnrow=false) {
        $this->conn();
        self::$query_type = 'insert';
        self::$query = 'insert into '.self::$table.' (';
        foreach($colsandvals as $col=>$val) {
            self::$query .= "$col, ";
        }
        self::$query = rtrim(self::$query, ', ').') values (';
        foreach($colsandvals as $col=>$val) {
            self::$query .= ":$col, ";
        }
        self::$query = rtrim(self::$query, ', ').')';
        if($returnrow) {
            return $this->returnrow($colsandvals, $returnrow);
        }
        return $this->run($colsandvals, $colsandvals);
    }

    public function insert_multi(array $rows, $returnrow=false) {
        $this->conn();
        $rowcount = count($rows[0]);
        $rowarr = array_fill(0, $rowcount, '?');
        $rowstr = '('.implode(', ', $rowarr).')';
        $allrowcount = count($rows);
        $allrowarr = array_fill(0, $allrowcount, $rowstr);
        $allrowstr = implode(', ', $allrowarr);
        if($returnrow) {
            return $this->returnrow($rows, $returnrow);
        }
        return $this->run($rows);
    }

    public function returnrow($insrows, $returnrow) {
        $rows = $returnrow===true ? '*' : $returnrow;
        /*
        self::$query_type = 'select';
        self::$query .= " RETURNING $rows"; //mysql 10.5
        */
        if($this->run($insrows) === true) {
            return $this->select($rows)->where('id=LAST_INSERT_ID()');
            // self::$query_type = 'select';
            // self::$query = "SELECT $rows from ".self::$table." where id=LAST_INSERT_ID()";
            // return $this->run();
        }
    }

    public function update(array $columns) {
        $this->conn();
        self::$query_type = 'update';
        self::$query = 'Update '.self::$table.' set ';
        foreach($columns as $key=>$val) {
            self::$query .= "$key = :$key,";
        }
        self::$query = rtrim(self::$query, ',');
        self::$update_arr = $columns;
        return self::$instance;
    }

    public function where($whquery, array $wharray=[]) {
        self::$query .= " where $whquery ";
        // self::$query .= self::$extra;
        switch(self::$query_type) {
            case 'update':
                $totalupdatearr = array_merge(self::$update_arr, $wharray);
                return $this->run($totalupdatearr);
            break;
            default:
                return $this->run($wharray);
        }
    }

    public function run(array $params=[]) {
        // echo self::$query; exit;
        $stmt = self::$conn->prepare(self::$query);
        $done = $stmt->execute($params);
        if($done) {
            switch(self::$query_type) {
                case 'select':
                    $data = $stmt->fetchAll();
                    return $data;
                break;
                default:
                    return true;
            }
        }
    }

    public function fetchcolumns() {
        $this->conn();
        self::$query_type = 'select';
        self::$query = 'show columns from '.self::$table;
        $columns = $this->run();
        if(is_array($columns) && count($columns)) {
            return array_column($columns, 'Field');
        }
    }

    public function custom_query($query, $querytype='select', array $queryvalues=[]) {
        $this->conn();
        self::$query_type = $querytype;
        self::$query = $query;
        return $this->run($queryvalues);
    }

    public function setvariable($sqlvariables) {
        // $str = $sqlvariables;
        $str = '';
        foreach($sqlvariables as $key=>$val) {
            $str .= "SET @$key := $val;";
        }

        self::$query = $str;
        self::$query_type = 'setvariable';
        return $this->run();
    }

    public function transaction(array $tabqueries, $querytype='select') {
        $this->conn();
        try {
            $res = [];
            self::$conn->beginTransaction();
            foreach($tabqueries as $key=>$val) {
                self::$table = $key;
                foreach($val as $subkey=>$subval) {
                    if(method_exists($this, $subkey)) {
                        $output = call_user_func_array([$this, $subkey], $subval);
                        if(is_array($output)) {
                            $res[] = $output;
                        }
                    } else {
                        self::$conn->rollback();
                        error_log("Transaction error: $key method not found");
                        return;
                    }
                }
            }
            self::$conn->commit();
        } catch (PDOEXCEPTION $e) {
            self::$conn->rollback();
            echo 'Transaction error: '.$e->getMessage();
            return;
        }
        return $res;
    }
}
// []
// BEGIN;
// insert into user (firstname, email, phone, writer) values ('Joey', 'joey@gmail.com', 070, 1);
// set @lastinsid := LAST_INSERT_ID();
// insert into writer (userid) values (@lastinsid);
// SELECT * FROM user where id=@lastinsid;
// COMMIT;