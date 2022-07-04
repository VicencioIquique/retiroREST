<?php
header('Access-Control-Allow-Origin: *');
	set_time_limit(300);
	require_once("../../clases/conexionocdb.php");
	require ('libreriaPresta.php');
try {
	$sku='';
	   // creating webservice access
	   $webService = new PrestaShopWebservice('https://www.vicencioperfumerias.cl/iquique','AKZZU9AGZNEW47C8SB6TGB3HJYA5GJF5', false); // se crea conexion
		$xml = $webService->get(array('resource' => 'orders')); // se genera una variable que obtiene los datos del xml entero de ordenes
		$opt = array(
			'resource'=>'orders',
			'display'=>'[id,reference]',
			'filter[current_state]'=>'4'
		);
		$xml = $webService->get($opt);    				 // se realiza la obtencion de datos con la variable opt
		$resources = $xml->orders->children(); // se asigna a la variable resource los hijos del xml de la orden 
		foreach ($resources as $key=>$resource){ 		// para cada hijo key sera el nombre del valor y resource el valor 
			$res[] = array( // asignar el vector 
				"id"=>(int)$resource->id,
				"referencia"=>(string)$resource->reference,
			);
		}
		echo json_encode($res);	 
	}
catch (PrestaShopWebserviceException $ex) {
   echo 'Error: <br />' . $ex->getMessage();
}