<?php 

class Request{

    public $request;
    public function __construct($request)
    {   
        $this->request = $request;
    }

    public function __get($key)
    {

        if (!isset($this->data[$key])){
            return NULL;
        }

        return $this->request[$key] ;

    }

    
    public function input($key,$default = 'NULL')
    {
        $items = explode(".",$key);
        $idxFinal = count($items)-1;

        $var = $this->request;
        foreach ($items as  $k => $item) {
            
            if(isset($var[$item])){
                $var = $var[$item];

            }else{

                if($idxFinal == $k ){
                    $var = $default;
                }else{
                    $var = array();
                }

            }

            
        }

        
        return $var;
        
    }
    
    public function all()
    {
        return $this->request;
    }
}





?> 