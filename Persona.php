<?php


class Persona
{
    private $name;
    private $dni;

    public function __construct($name,$dni)
    {
        $this->name = $name;
        $this->dni = $dni;
    }

    public function getDni() : int{
        return $this->dni;
    }

    public function toString(): string{
        $persona = ['name'=> $this->name, 'dni' => $this->dni];
        return json_encode( $persona);
    }
}
