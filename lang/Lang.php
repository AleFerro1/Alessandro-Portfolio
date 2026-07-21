<?php 

class Lang {

    function __construct(private string $lang){}

    public function get_string(string $type){
        $file = __DIR__ . '/languages/' . $this->lang . '.php';
        if(file_exists($file)){
            require $file;
        } else {
            return "Errore interno - file di lingua non trovato";
        }

        if (!isset($string[$type])) {
            return "Errore interno - chiave di lingua non trovata";
        }

        return $string[$type];
    }
}