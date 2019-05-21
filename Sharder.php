<?php
require './MongoDb.php';


class Sharder
{   
    private $DBs;
    private $indices;
    private $cola;
    private $cantDBs;


    public function __construct($cola){
        $this->cantDBs=0;
        $this->DBs[] = new MongoDB($this->cantDBs);
        $this->cantDBs++;
        $this->indices = [] ;
        $this->cola = $cola;
    }

    public function agregarServidor(){
        $this->DBs[] = new MongoDB($this->cantDBs);
        $this->cantDBs++;
    }

    public function guardar( Persona $persona ){
        $a_donde = $persona->getDni() % count( $this->DBs );        
        $this->DBs[ $a_donde ]->add($persona);
        $this->indices[$persona->getDni()] = $a_donde;        
    }

    public function resharding(){        
        $this->agregarServidor();
        $indicesResharding = [];
        foreach ( $this->indices as $dni => $indiceDB) {
            $indicesResharding[$dni] = $dni % count( $this->DBs );
        }

        foreach ( $this->indices as $dni => $indiceDB) {
            if( $indiceDB !== $indicesResharding[ $dni ]){

                $this->cola->agregar([ 'desde' => $indiceDB, 'a_donde' => $indicesResharding[ $dni ], 'element' => $this->DBs[$indiceDB]->transferPersona($dni) ]);
                
            }
        }
        $this->indices = $indicesResharding;        
    }

    public function mostrarIndices(){
        $servers = [];
        foreach ($this->indices as $value) {
            isset( $servers[$value]) ? $servers[$value] ++ : $servers[$value]=1;
        }
        $respuesta = '';
        foreach ($servers as $key => $value) {
            $respuesta .= "server: ".$key." $value registros\n"; 
        }
        return $respuesta . "servidores : ".count($this->DBs);
    }    

    public function migrar(){
        while ( !$this->cola->vacio() ){
            $transfer = $this->cola->sacar();
            $this->DBs[ $transfer['desde'] ]->remove( $transfer['element'] );
            $this->DBs[ $transfer['a_donde'] ]->add( $transfer['element'] );
        }
    }

}
