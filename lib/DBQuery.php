<?php
    namespace Amin\ArrayticsLib;
    class DBQuery extends Database {
        protected $table = "";
        private $select_columns = "*";
        private $condi = [];
        private $condi_or = [];
        private $condi_values = [];
        private $condi_between = [];
        private $orderBy = [];
        private $with_relations = [];
        private $current_query_data=[];
        private $db_operations = 1; //[1=select,delete,2=insert,update]
        private $class_attributes=[
            'with_relations' => [],
            'current_query_data' => null,
            'class_attributes' => [],
            'db_operations' => [],
            'table' => '',
            'select_columns' => '*',
            'condi' => [],
            'condi_or' => [],
            'condi_values' => [],
            'condi_between' => [],
            'orderBy' => [],
        ];
        public function __construct() {
            Database::getInstance();
            $this->db_operations = 1;
        }
        public function create($data) {
            $data['entry_at'] = date('Y-m-d');
            $columnString = implode(',', array_keys($data));
            $valueString = implode(',', array_fill(0, count($data), '?'));
            $statm = self::getConnection()->prepare("INSERT INTO {$this->table} ({$columnString}) VALUES ({$valueString})");
            $statm->execute(array_values($data));
            $lastId= self::getConnection()->lastInsertId();
            return $lastId;
        }
        public function where($condi, $param = null, $param2 = null) {
            if(is_callable($condi) && $condi != 'date'){
                $condi($this);
            }
            else{
                $this->handleWhere('condi', $condi, $param, $param2);
            }
            return $this;
        }
        private function handleWhere($property, $condi, $param = null, $param2 = null) {
            if (is_array($condi)) {
                foreach ($condi as $key => $val) {
                    if(is_array($val)){
                        $symbol = "=";
                        if(is_array($val)){
                            $symbol = $val[1];
                            $key = $val[0];
                            $val = $val[2];
                        }
                        $this->$property[] = "{$key} {$symbol}? ";
                        $this->condi_values[] = $val;
                    }else{
                        $this->$property[] = "{$key}=? ";
                        $this->condi_values[] = $val;
                    }
                }
            } 
            else if (!empty($param)) {
                $symbol = "=";
                if (!empty($param2)) {
                    $symbol = $param;
                    $param = $param2;
                }
                $this->$property[] = "{$condi} {$symbol}? ";
                $this->condi_values[] = $param;
            }
        }
        public function orderBy($col, $val="asc") {
            if(is_array($col)) {
                foreach ($col as $key => $value) {
                    $this->orderBy[] = " {$key} {$value}";
                }
                return $this;
            }
            $this->orderBy[] = " {$col} {$val}";
            return $this;
        }
        public function get() {
            $sql = "SELECT {$this->select_columns} FROM {$this->table} {$this->getCond()}";
            //echo $sql;
            $stmt = self::getConnection()->prepare($sql);
            $stmt->execute($this->condi_values);
            $data=$stmt->fetchAll(\PDO::FETCH_OBJ);
            return $data;
        }
        private function getCond() {
            $where = "";$where_or = "";
            $whereBetween = "";$orderBy="";
            if (count($this->condi) > 0) {
                $where = " And " . implode("And ", $this->condi);
            }
            if (count($this->condi_or) > 0) {
                $where_or = " OR " . implode("OR ", $this->condi_or);
            }
            if (count($this->condi_between) > 0) {
                $whereBetween = " And " . implode("And ", $this->condi_between);
            }
            if(count($this->orderBy)>0)
                $orderBy=" ORDER BY ".implode(",", $this->orderBy);
            return " WHERE 1 {$where} {$whereBetween} {$where_or} {$orderBy}";
        }
}
    

?>