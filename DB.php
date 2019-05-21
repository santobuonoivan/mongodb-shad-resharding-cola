<?php


class DB
{
    private  $MAX_DB = 1000000;
    private $personas;

    public function __construct(){
        $this->personas = [];
    }
    public function add( Persona $persona){
        $this->personas[ $persona->getDni()] = $persona; 
    }
    public function remove( Persona $persona){
        unset( $this->personas[ $persona->getDni()]); 
    }
    public function transferPersona(int $dni ) : Persona{
        return $this->personas[ $dni ];
    }
    public function isFull() : bool{
        return count( $this->personas ) >= $this->MAX_DB;
    }
    public function existe(int $dni):bool{
        return array_key_exists( $dni ,$this->personas);
    }
    public function getID( Persona $per ): int {
        foreach ($this->personas as $key => $persona) {
            if( $persona === $per){
                return $key;
            }
        }
        return -1;
    }
}
