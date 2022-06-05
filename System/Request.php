<?php 

class Request{

    private $request;
    private $files;

    public function __construct()
    {   
        
        $content = file_get_contents('php://input');
        $json = $content == '' ? array() : json_decode($content,true);
        $request = array_merge($_REQUEST,$json);

        $this->request = $request;
        $this->files = $_FILES;
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


    public function file($key,$default = null)
    {
        if(isset($this->files[$key])){
            $file = $this->files[$key];
    
            $file["name"] = "FILE".time().$file["name"];
            return $file[$key];
        }else{
            return $default;
        }
    }

    public function fileSize($key)
    {
        return $this->files[$key]["size"];
    }

    public function allFiles()
    {
        return $this->files;
    }

    public function hasFile($key)
    {
        return isset($_FILES[$key]) && !empty($_FILES[$key]["tmp_name"]);
    }



}





?> 