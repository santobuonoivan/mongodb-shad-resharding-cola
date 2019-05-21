<?php

use MongoDB\Client;
class MongoDB
{
	private $client;
	private $db;
	private $personas;

	public function __construct($db = 'db', $personas = 'personas')
	{
		$this->client = new MongoDB\Client("mongodb://localhost:27017");
		$this->db = $this->client->{$db};
		$this->personas = $this->db->{$personas};
	}
    
    
	public function transferPersona( $dni ){
        $result = $this->personas->findOne( [ 'dni' => (int)$dni ] );
        $result = json_decode($result['value'] );
        //var_dump($result);
		return new Persona($result->name, $result->dni);		
	}
	
	public function add( Persona $persona) : bool{
		
        $result = $this->personas->insertOne( [ 'dni' => $persona->getDni(), 'value' => $persona->toString()] );
        if($result->isAcknowledged() == 1){
            return true;
        }else {
            return false;
        }		
	}
		
	public function remove( Persona $persona ){
		$deleteResult = $this->personas->deleteOne([ 'dni' => $persona->getDni() ]);
		return $deleteResult->getDeletedCount() > 0 ? true : false; 
	}

    

}
