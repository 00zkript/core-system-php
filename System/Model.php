<?php


class Model
{


    protected $table;
    protected $primarykey;

    private $data;
    private $select;
    private $join;
    private $where;
    private $groupBy;
    private $orderBy;
    private $offset;
    private $limit;
    private $raw;

    protected $server;
    protected $db;
    protected $user;
    protected $pass;
    private $cnx;
    

    public function __construct()
    {
        $this->setSelect();
        $this->setWhere();
        $this->setJoin();
        $this->setGroupBy();
        $this->setOrderBy();
        $this->setLimit();
        $this->setOffset();
        $this->setRaw();

    } 

    public function initConexion()
    {
        try {

            $cn = new PDO("mysql:host=" .$this->server . ";dbname=" . $this->db . "", $this->user, $this->pass);
            $cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $cn;       
        } catch (PDOException $e) {
            //$cn = $e->__toString();
            echo '<pre>';
            print_r("ERROR: ".$e->getMessage());
            echo '</pre>';

        }
        
    }

    public function getConexion()
    {
        if (!isset($this->cnx) || empty($this->cnx)) {
            $this->cnx = $this->initConexion();
        }

        return $this->cnx;
    }
    
    public function setConexion($server, $db, $user,$pass)
    {
        $this->server = $server;
        $this->db     = $db;
        $this->user   = $user;
        $this->pass   = $pass;
        return $this;
    }

    public function execute($query)
    {
        
        $cn = $this->getConexion();
        $rs = $cn->prepare($query);
        $rs->execute();

        return $rs;


    }

    
    public function query()
    {
        $this->setSelect();
        $this->setWhere();
        $this->setJoin();
        $this->setGroupBy();
        $this->setOrderBy();
        $this->setLimit();
        $this->setOffset();
        $this->setRaw();
        return $this;
    }

    
    
    public function get()
    {
        $response = $this->execute($this->toSql());
        return $response->fetchAll(PDO::FETCH_ASSOC);
    }

    public function first()
    {
        $response = $this->execute($this->toSql());
        return $response->fetch(PDO::FETCH_ASSOC);
    }

    public function dd()
    {
        echo "<pre>";
        print_r($this->toSql());
        echo "</pre>";
        exit;
    }

    public function setData()
    {
        foreach ( $this->rawQuery("SHOW COLUMNS FROM " . $this->table)->get() as $item ) {
            $this->data[$item["Field"]] = null;
            
        }
        
        return $this;
    }

    
    protected function setSelect($select = array())
    {
        $this->select = $select;
        return $this;
    }

    protected function setTable($table = null)
    {
        $this->table = $table;
        return $this;
    }

    protected function setWhere($where = array())
    {
        $this->where = $where;
        return $this;
    }

    protected function setJoin($join = array())
    {
        $this->join = $join;
        return $this;
    }

    protected function setGroupBy($groupBy = array())
    {
        $this->groupBy = $groupBy;
        return $this;
    }

    protected function setOrderBy($orderBy = array())
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    protected function setLimit($limit = null)
    {
        $this->limit = $limit;
        return $this;
    }

    protected function setOffset($offset = null)
    {
        $this->offset = $offset;
        return $this;
    }

    protected function setRaw($raw = null)
    {
        $this->raw = $raw;
        return $this;
    }

    



    public function rawQuery($query)
    {
        $this->raw = $query;
        return $this;
    }

    public function select($columns)
    {
   
        if(gettype($columns) == "array"){
            $this->select = $columns;
        }

        if(gettype($columns) == "string"){
            $this->select = explode(",",$columns);
        }
        
        return $this;
    }

    public function table($table,$primarykey = null)
    {

        $this->table = $table;
        if(!empty($primarykey)){
            $this->primarykey = $primarykey;
        }

        

        return $this;
    }

    public function join($table,$key1,$operation,$key2,$type = "INNER")
    {
        $this->join[] = [
            "table" => $table,
            "key1" => $key1,
            "operation" => $operation,
            "key2" => $key2,
            "type" => $type
        ];

        return $this;
    }
  

    public function leftJoin($table,$key1,$operation,$key2)
    {
        $this->join[] = [
            "table" => $table,
            "key1" => $key1,
            "operation" => $operation,
            "key2" => $key2,
            "type" => "LEFT"
        ];

        return $this;
    }

    public function rightJoin($table,$key1,$operation,$key2)
    {
        $this->join[] = [
            "table" => $table,
            "key1" => $key1,
            "operation" => $operation,
            "key2" => $key2,
            "type" => "RIGHT"
        ];

        return $this;
    }

    public function where($column,$operation,$value)
    {
        $this->where[] = [
            "column" => $column,
            "operation" => $operation,
            "value" => $value
        ];
        

        return $this;
    }

    public function orWhere($column,$operation,$value)
    {
        $this->where[] = [
            "column" => $column,
            "operation" => $operation,
            "value" => $value,
            "or" => true
        ];
        

        return $this;
    }

    public function whereIn($column,$values)
    {
        $this->where[] = [
            "column" => $column,
            "operation" => "IN",
            "value" => $values
        ];
        

        return $this;
    }

    public function orWhereIn($column,$values)
    {
        $this->where[] = [
            "column" => $column,
            "operation" => "IN",
            "value" => $values,
            "or" => true
        ];
        

        return $this;
    }

    public function whereNotIn($column,$values)
    {
        $this->where[] = [
            "column" => $column,
            "operation" => "NOT IN",
            "value" => $values
        ];
        

        return $this;
    }

    public function whereNull($column)
    {
        $this->where[] = [
            "column" => $column,
            "operation" => "IS NULL"
        ];
        

        return $this;
    }

    public function orWhereNull($column)
    {
        $this->where[] = [
            "column" => $column,
            "operation" => "IS NULL",
            "or" => true
        ];
        

        return $this;
    }
    public function whereNotNull($column)
    {
        $this->where[] = [
            "column" => $column,
            "operation" => "IS NOT NULL"
        ];
        

        return $this;
    }

    public function whereDate($column,$operation,$value)
    {
        $this->where[] = [
            "column" => "DATE($column)",
            "operation" => $operation,
            "value" => $value
        ];
        

        return $this;
    }

    public function orWhereDate($column,$operation,$value)
    {
        $this->where[] = [
            "column" => "DATE($column)",
            "operation" => $operation,
            "value" => $value,
            "or" => true
        ];
        

        return $this;
    }

    public function whereTime($column,$operation,$value)
    {
        $this->where[] = [
            "column" => "TIME($column)",
            "operation" => $operation,
            "value" => $value
        ];
        

        return $this;
    }

    public function orWhereTime($column,$operation,$value)
    {
        $this->where[] = [
            "column" => "TIME($column)",
            "operation" => $operation,
            "value" => $value,
            "or" => true
        ];
        

        return $this;
    }

    public function whereYear($column,$operation,$value)
    {
        $this->where[] = [
            "column" => "YEAR($column)",
            "operation" => $operation,
            "value" => $value
        ];
        

        return $this;
    }
    public function orWhereYear($column,$operation,$value)
    {
        $this->where[] = [
            "column" => "YEAR($column)",
            "operation" => $operation,
            "value" => $value,
            "or" => true
        ];
        

        return $this;
    }

    public function whereMonth($column,$operation,$value)
    {
        $this->where[] = [
            "column" => "MONTH($column)",
            "operation" => $operation,
            "value" => $value
        ];
        

        return $this;
    }

    public function orWhereMonth($column,$operation,$value)
    {
        $this->where[] = [
            "column" => "MONTH($column)",
            "operation" => $operation,
            "value" => $value,
            "or" => true
        ];
        

        return $this;
    }

    public function whereDay($column,$operation,$value)
    {
        $this->where[] = [
            "column" => "DAY($column)",
            "operation" => $operation,
            "value" => $value
        ];
        

        return $this;
    }

    public function orWhereDay($column,$operation,$value)
    {
        $this->where[] = [
            "column" => "DAY($column)",
            "operation" => $operation,
            "value" => $value,
            "or" => true
        ];
        

        return $this;
    }

    public function orderBy($column,$order = "ASC")
    {
        $this->orderBy[] = [
            "column" => $column,
            "order" => $order
        ];

        return $this;
    }

    public function between($column,$min,$max)
    {
        $this->where[] = [
            "column" => $column,
            "operation" => "BETWEEN",
            "value" => [$min,$max]
        ];

        return $this;
    }
    public function orBetween($column,$min,$max)
    {
        $this->where[] = [
            "column" => $column,
            "operation" => "BETWEEN",
            "value" => [$min,$max],
            "or" => true
        ];

        return $this;
    }

    public function groupBy($column)
    {
        $this->groupBy[] = $column;

        return $this;
    }


    public function offset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    public function limit($limit)
    {
        $this->limit = $limit;

        return $this;
    }
   
    public function build()
    {

        $sql = " FROM ". $this->table;

        if(count($this->join) > 0){
            foreach($this->join as $join){
                $sql .= " ".$join["type"]." JOIN ".$join["table"]." ON ".$join["key1"]." ".$join["operation"]." ".$join["key2"];
            }
        }

        if(count($this->where) > 0){
            $sql .= " WHERE ";
            $where = [];
            foreach($this->where as $key => $value){
                $sqlWhere = "";
                
                if($key != 0){
                    if(isset($value["or"])){
                        $sqlWhere .= " OR ";
                    }else{
                        $sqlWhere .= " AND ";
                    }
                }

                if($value["operation"] == "IN"){
                    $sqlWhere .= $value["column"]." ".$value["operation"]." (".implode(",",$value["value"]).")";
                }

                if($value["operation"] == "BETWEEN"){
                    $sqlWhere .= "(".$value["column"]." ".$value["operation"]." ".$value["value"][0]." AND ".$value["value"][1].")";
                }
                
                if($value["operation"] == "IS NULL" || $value["operation"] == "IS NOT NULL"){
                    $sqlWhere .= $value["column"]." ".$value["operation"];
                }

                if(!is_array($value["value"])){
                    $sqlWhere .= $value["column"]." ".$value["operation"]."'".$value["value"]."'";
                }
                



                $where[] = $sqlWhere;

            }
            $sql .= implode(" ",$where);
        }

        if(count($this->orderBy) > 0){
            $sql .= " ORDER BY ";
            $orderBy = [];
            foreach($this->orderBy as $key => $value){
                $orderBy[] = $value["column"]." ".$value["order"];
            }
            $sql .= implode(",",$orderBy);
        }
        
        if(count($this->groupBy) > 0){
            $sql .= " GROUP BY ";
            $groupBy = [];
            foreach($this->groupBy as $key => $value){
                $groupBy[] = $value;
            }
            $sql .= implode(",",$groupBy);
        }
        

        if($this->limit != null){
            $sql .= " LIMIT ".$this->limit;
        }

        if($this->offset != null){
            $sql .= " OFFSET ".$this->offset;
        }

      
        return $sql;

    }

    public function toSql()
    {

        if(!empty($this->raw)){
            return $this->raw;
        }

        if(!isset($this->table) || empty($this->table)){
            throw new \Exception("Se necesita una tabla para poder construir la consulta");
        }


        $query = "SELECT ";

        if(count($this->select) > 0){
            $query .= implode(",",$this->select);
        }else{
            $query .= "*";
        }

        $query .= $this->build();


        return $query;
    }

    public function paginate($paginaActual = 0, $cantidadRegistros = 10)
    {

        
        $rsTotal = (new self)
            ->setConexion($this->server,$this->db,$this->user,$this->pass)
            ->select("COUNT(*) AS total")
            ->setTable($this->table)
            ->setJoin($this->join)
            ->setWhere($this->where)
            ->setGroupBy($this->groupBy)
            ->setOrderBy($this->orderBy)
            ->first();
        
    
        $totalRegistros =  $rsTotal["total"] ?? 0;

        if ($paginaActual <= 0 ){
            $paginaActual = 1;
        }

        $pagination['total']             = $totalRegistros;
        $pagination['paginaActual']      = $paginaActual ;
        $pagination['ultimaPagina']      = $this->totalPaginas($cantidadRegistros,$totalRegistros );
        $pagination['offset']            = 3;
        $pagination['to']                = 3;
        $pagination['from']              = 3;
        $pagination['paginas']           = $this->numerosPaginas($pagination);
        $pagination['cantidadRegistros'] = $cantidadRegistros;

        // $paginaActual = ($paginaActual - 1 ) ;
        // $result = array_chunk($registros,$cantidadRegistros);

        $paginaActual = ($paginaActual - 1 ) * $cantidadRegistros;


        $this->offset($paginaActual);
        $this->limit($cantidadRegistros);
        $result = $this->get();
        
       


        return array(
            "data" => $result,
            "pagination" => $pagination,
        );

    }




    private function totalPaginas($cantidadRegistros,$total)
    {
        $totalPaginas = ceil($total /$cantidadRegistros);
        return $totalPaginas;
    }

    private function numerosPaginas($pagination)
    {

        if(!$pagination["to"]){
            return array();
        }

        $from = $pagination["paginaActual"] - $pagination["offset"];
        if($from < 1){
            $from = 1;
        }

        $to = $from + ($pagination["offset"] * 2);
        if($to >= $pagination["ultimaPagina"]){
            $to = $pagination["ultimaPagina"];
        }

        $pagesArray = array();
        while($from <= $to){
            array_push($pagesArray,$from);
            $from++;
        }
        return $pagesArray;

    }

    public function find($id)
    {
        if(!isset($this->primarykey) || empty($this->primarykey)){
            throw new \Exception("Se necesita una llave primaria para poder construir la consulta");
        }

        $cx = new self;
        $cx->setConexion($this->server,$this->db,$this->user,$this->pass);
        $cx->setSelect($this->select);
        $cx->setTable($this->table);
        $cx->setWhere($this->where);
        $cx->where( $this->primarykey ,"=", $id);

        $this->data = $cx->first();
        return $this;
    }


    public function all()
    {
        $cx = new self;
        $cx->server = $this->server;
        $cx->db = $this->db;
        $cx->user = $this->user;
        $cx->pass = $this->pass;
        $cx->select = $this->select;
        $cx->table = $this->table;
        $cx->where = $this->where;
        $cx->limit = null;
        $cx->offset = null;
        return $cx->get();
    }

    public function toArray()
    {
        return $this->data;
    }

    public function toJson()
    {
        return json_encode($this->data);
    }

    public function insert($data)
    {
        $keys = array_keys($data);
        $valuesData = array_values($data);
        


        $values = array();
        foreach($valuesData as $item){

            $castInt = array( "int", "integer" );
            $castOther = array( "array", "object" );

            $tipoDato = gettype($item);
            
            
            if (in_array($tipoDato,$castInt)) {
                $values[] = (int) $item;
                
            }else if(in_array($tipoDato,$castOther)){

                $json = json_encode($item,JSON_FORCE_OBJECT);
                $values[] = "'$json'";
            } else {
                $values[] = "'$item'";
            }

        }
  
        $columns = implode(",",$keys);
        $values = implode(",",$values);
        $query = "INSERT INTO ".$this->table." (".$columns.") VALUES (".$values.")";
        $this->execute($query);
        $id = $this->getConexion()->lastInsertId();
        $this->find($id);

        return $this;
    }

    public function save()
    {
        $data = $this->data;
        return $this->insert($data);
      
    }

    public function update()
    {

        $data = $this->data;
        $primarykey = $data[$this->primarykey];
        unset($data[$this->primarykey]);

        $query = "UPDATE ".$this->table." SET ";
        $values = array();
        foreach($data as $column => $value){

            $castInt = array( "int", "integer" );
            $castOther = array( "array", "object" );
            $tipoDato = gettype($value);
            
            
            if (in_array($tipoDato,$castInt)) {
                $values[] = $column." = ".(int) $value;
                
            }else if(in_array($tipoDato,$castOther)){

                $json = json_encode($value,JSON_FORCE_OBJECT);
                $values[] = $column." = '$json' ";
            }else if($value === null) {
                $values[] = $column." = null ";
            } else  {
                $values[] = $column." = '$value' ";
            }
            
        }
        $query .= implode(",",$values);
        $query .= " WHERE ".$this->primarykey." = ".$primarykey;

        $this->execute($query);

        return $this;
    }

    public function delete()
    {
        $primarykey = $this->data[$this->primarykey];
        $query = "DELETE FROM ".$this->table." WHERE ".$this->primarykey." = ".$primarykey;
        $this->execute($query);
        return $this;
    }

    public function when($value, $callback, $default = null)
    {
        if ($value) {
            return $callback($this, $value) ?: $this;
        } elseif ($default) {
            return $default($this, $value) ?: $this;
        }

        return $this;
    }

    public function __get($name)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }
        return null;
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

}







