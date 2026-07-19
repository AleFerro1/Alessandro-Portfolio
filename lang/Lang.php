<?php 

class Lang {

    function __construct(private string $lang){}

    public function get_string(string $type){
        $file = 'languages/' . $this->lang . '.php';
        require $file;
        return $string[$type];
    }
}