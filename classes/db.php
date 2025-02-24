<?php
trait Db {
    private static $query;
    private static $extra;
    private static $query_type;
    private static $insert_arr;
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
        self::$query = "select $columns from ".static::$table." $as ";
        // self::$extra = $extra;
        return self::$instance;
    }

    public function join($jointype, $table, $cols, $alias='') {
        $as = $alias ? "as $alias" : '';
        self::$query .= " $jointype $table $as on $cols";
        return self::$instance;
    }

    public function all($extra='', $params=[]) {
        self::$query .= " $extra";
        return $this->run($params);
    }

    public function insert(array $colsandvals, $self=false) {
        $this->conn();
        self::$query_type = 'insert';
        self::$query = 'insert into '.static::$table.' (';
        foreach($colsandvals as $col=>$val) {
            self::$query .= "$col, ";
        }
        self::$query = rtrim(self::$query, ', ').') values (';
        foreach($colsandvals as $col=>$val) {
            self::$query .= ":$col, ";
        }
        self::$query = rtrim(self::$query, ', ').')';
        if($self===true) {
            //$returnrow, $updateduplicate=false
            self::$insert_arr = $colsandvals;
            return self::$instance;
        }
        // if($returnrow) {
        //     return $this->returnrow($colsandvals, $returnrow);
        // }
        // if($updateduplicate===true) {
        //     self::$insert_arr = 
        //     return self::$instance;
        // }
        return $this->run($colsandvals, $colsandvals);
    }

//     "INSERT INTO diamond (email, currency, amount)
// VALUES ('ashleyberry1979@gmail.com', 'GBP', 20)
// ON DUPLICATE KEY UPDATE
//     currency='GBP', amount=amount+20"

    public function on_duplicate_key($query, array $params=[]) {
        self::$query .= " ON DUPLICATE KEY $query ";
        // show(self::$insert_arr);
        self::$insert_arr = array_merge(self::$insert_arr, $params);
        return self::$instance;
    }

    public function go() {
        return $this->run(self::$insert_arr);
    }

    public function insert_multi(array $rows, $self=false) {
        $this->conn();
        self::$query_type = 'insert';
        $params = str_repeat('?, ', count($rows[0]) - 1) . '?';
        self::$query = "INSERT INTO ".static::$table." (".implode(', ', array_keys($rows[0])).") VALUES " . str_repeat("($params), ", count($rows) - 1) . "($params)";
        foreach($rows as $val) {
            $data[] = array_values($val);
        }
        if($self===true) {
            self::$insert_arr = array_merge(...$data);
            return self::$instance;
        }
        return $this->run(array_merge(...$data));
    }

    public function returnrow($returnrow) {
        $rows = $returnrow===true ? '*' : $returnrow;
        /*
        self::$query_type = 'select';
        self::$query .= " RETURNING $rows"; //mysql 10.5
        */
        if($this->run(self::$insert_arr) === true) {
            return $this->select($rows)->where('id=LAST_INSERT_ID()');
            // self::$query_type = 'select';
            // self::$query = "SELECT $rows from ".self::$table." where id=LAST_INSERT_ID()";
            // return $this->run();
        }
    }

    public function update(array $columns, $positional=false) {
        $this->conn();
        self::$query_type = 'update';
        self::$query = 'Update '.static::$table.' set ';
        if($positional) {
            self::$query .= implode('=?, ', array_keys($columns)).'=? ';
            $columns = array_values($columns);
        } else {
            foreach($columns as $key=>$val) {
                self::$query .= "$key = :$key,";
            }
        }
        self::$query = rtrim(self::$query, ',');
        self::$update_arr = $columns;
        return self::$instance;
    }
    
    public function delete() {
        $this->conn();
        self::$query_type = 'delete';
        self::$query = "Delete from ".static::$table;
        return self::$instance;
    }

    public function where($whquery, array $wharray=[]) {
        self::$query .= " where $whquery ";
        // self::$query .= self::$extra;
        switch(self::$query_type) {
            case 'update':
                $totalupdatearr = array_merge(self::$update_arr, $wharray);
                // show($totalupdatearr);
                return $this->run($totalupdatearr);
            break;
            default:
                return $this->run($wharray);
        }
    }

    public function run(array $params=[]) {
        // echo self::$query.'<br>';
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
        self::$query = 'show columns from '.static::$table;
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

    public function setvariable(array $sqlvariables, array $params=[]) {
        // $str = $sqlvariables;
        $str = '';
        foreach($sqlvariables as $key=>$val) {
            $str .= "SET @$key := $val;";
        }

        self::$query = $str;
        self::$query_type = 'setvariable';
        return $this->run($params);
    }
    
    public function transaction(array $tabqueries, $querytype='select') {
        $this->conn();
        try {
            $res = [];
            self::$conn->beginTransaction();
            foreach($tabqueries as $key=>$val) {
                self::$table = $key;
                foreach($val as $subkey=>$subval) {
                    if(str_starts_with_number($subkey)) {
                        $osubkey=$subkey;
                        $subkey = trim_starting_number($subkey);
                    } else {
                        $osubkey = null;
                    }
                    if(method_exists($this, $subkey)) {
                        $output = call_user_func_array([$this, $subkey], $subval);
                        // if(is_array($output)) {
                        //     $res[] = $output;
                        // }
                        $res[$key][$osubkey ?? $subkey] = is_object($output) ? 'object' : $output;
                    } else {
                        self::$conn->rollback();
                        error_log("Transaction error: $subkey method not found");
                        return;
                    }
                }
            }
            self::$conn->commit();
        } catch (PDOEXCEPTION $e) {
            self::$conn->rollback();
            // echo 'Transaction error: '.$e->getMessage();
            error_log('Transaction error: '.$e->getMessage());
            return;
        }
        return $res;
    }
}
/*
    [
        'table1'=>['insert'=>[]]
    ]
*/
// []
// BEGIN;
// insert into user (firstname, email, phone, writer) values ('Joey', 'joey@gmail.com', 070, 1);
// set @lastinsid := LAST_INSERT_ID();
// insert into writer (userid) values (@lastinsid);
// SELECT * FROM user where id=@lastinsid;
// COMMIT;