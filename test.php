<?php
require './vendor/autoload.php';
require './Persona.php';
require './Sharder.php';
require './Cola.php';

$cola = new Cola();

const VALUE = 10;
$personas = [];

for ($i=0; $i < VALUE; $i++) { 
    $personas[] = new Persona('asd'.$i,$i);
}

$sharder = new Sharder($cola);
echo "guardoando ".(VALUE/2)."personas\n";
for ($i=0; $i < VALUE/2; $i++) { 
    $sharder->guardar($personas[$i]);
}

echo $sharder->mostrarIndices()."\n";
echo "guardoando ".(VALUE/2)."personas más\n";

for ($i=VALUE/2;  $i< VALUE; $i++) { 
    $sharder->guardar($personas[$i]);
}
echo "************Info*****************\n";
echo $sharder->mostrarIndices()."\n";
echo "*******************************\n";
echo "************* Cola ************\n";
echo 'canticad en espera'. count($cola->cola)."\n";
echo "*******************************\n";


echo "shading 1\n";
$sharder->resharding();


echo "************* Cola ************\n";
echo 'canticad en espera'. count($cola->cola)."\n";
echo "*******************************\n";

$sharder->migrar();

echo "migrardo cola \n";

echo "shading 2\n";
$sharder->resharding();

echo "************* Cola ************\n";
echo 'canticad en espera'. count($cola->cola)."\n";
echo "*******************************\n";

$sharder->migrar();

echo "************* Cola ************\n";
echo 'canticad en espera'. count($cola->cola)."\n";
echo "*******************************\n";

echo "************Info***************\n";
echo $sharder->mostrarIndices()."\n";
echo "*******************************\n";
