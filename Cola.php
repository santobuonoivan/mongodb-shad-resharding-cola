<?php

class Cola
{   

    public $cola;

    public function __construct()
    {
        $this->cola = [];
    }

    public function agregar($element){
        array_push( $this->cola, $element ) ;
    }

    public function sacar(){
        return array_shift( $this->cola);
    }
    public function vacio(){
        return empty( $this->cola );
    }
}
